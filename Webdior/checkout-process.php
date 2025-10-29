<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /Webdior/page/checkout.php');
	exit;
}

$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'checkout')) {
	$_SESSION['checkout_errors'] = ['Phiên không hợp lệ (CSRF).'];
	header('Location: /Webdior/page/checkout.php');
	exit;
}

$first = trim($_POST['first_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$district = trim($_POST['district'] ?? '');
$ward = trim($_POST['ward'] ?? '');
$payment = $_POST['payment_method'] ?? 'cod';

$errors = [];
if ($first==='') $errors[] = 'Vui lòng nhập Tên.';
if ($last==='') $errors[] = 'Vui lòng nhập Họ.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ';
if ($phone==='') $errors[] = 'Vui lòng nhập Số điện thoại';
if ($address==='') $errors[] = 'Vui lòng nhập Địa chỉ';
if ($city==='') $errors[] = 'Vui lòng nhập Tỉnh/Thành';
if ($district==='') $errors[] = 'Vui lòng nhập Quận/Huyện';
if ($ward==='') $errors[] = 'Vui lòng nhập Phường/Xã';

if ($errors) {
	$_SESSION['checkout_errors'] = $errors;
	header('Location: /Webdior/page/checkout.php');
	exit;
}

$userId = $_SESSION['user_id'] ?? null;
$ownerVal = $userId ?: session_id();
$ownerField = $userId ? 'user_id' : 'session_id';

$items = fetchAll("SELECT ci.product_id, ci.quantity, p.price, p.sale_price FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.$ownerField = ?", [$ownerVal]);
if (!$items) {
	$_SESSION['checkout_errors'] = ['Giỏ hàng trống.'];
	header('Location: /Webdior/page/checkout.php');
	exit;
}

$subtotal = 0;
foreach ($items as $it) {
	$unit = $it['sale_price'] !== null && $it['sale_price'] !== '' ? (float)$it['sale_price'] : (float)$it['price'];
	$subtotal += $unit * (int)$it['quantity'];
}
$shippingRow = fetchOne("SELECT setting_value FROM settings WHERE setting_key = 'shipping_fee'");
$freeRow = fetchOne("SELECT setting_value FROM settings WHERE setting_key = 'free_shipping_threshold'");
$shipping = (float)($shippingRow['setting_value'] ?? 0);
$freeThreshold = (float)($freeRow['setting_value'] ?? 0);
if ($freeThreshold > 0 && $subtotal >= $freeThreshold) {
	$shipping = 0;
}
$grand = $subtotal + $shipping;

$pdo = beginTransaction();
try {
	$orderNumber = 'OD' . date('YmdHis') . rand(100,999);
	$orderId = insertAndGetId(
		"INSERT INTO orders (order_number, user_id, customer_name, customer_email, customer_phone, customer_address, customer_city, customer_district, customer_ward, total_amount, shipping_fee, discount_amount, status, payment_method, payment_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'pending', ?, 'pending', NOW())",
		[
			$orderNumber,
			$userId,
			trim($first.' '.$last),
			$email,
			$phone,
			$address,
			$city,
			$district,
			$ward,
			$grand,
			$shipping,
			$payment
		]
	);

	foreach ($items as $it) {
		$unit = $it['sale_price'] !== null && $it['sale_price'] !== '' ? (float)$it['sale_price'] : (float)$it['price'];
		$total = $unit * (int)$it['quantity'];
		executeStatement("INSERT INTO order_items (order_id, product_id, quantity, price, total_price, created_at) VALUES (?, ?, ?, ?, ?, NOW())", [$orderId, $it['product_id'], $it['quantity'], $unit, $total]);
	}

	// Xóa giỏ hàng
	executeStatement("DELETE FROM cart_items WHERE $ownerField = ?", [$ownerVal]);

	commitTransaction($pdo);
	$_SESSION['checkout_success'] = 'Đặt hàng thành công. Mã đơn: ' . $orderNumber;
	header('Location: /Webdior/page/tai-khoan.php#don-hang');
	exit;
} catch (Exception $e) {
	rollbackTransaction($pdo);
	$_SESSION['checkout_errors'] = ['Lỗi hệ thống khi tạo đơn hàng.'];
	header('Location: /Webdior/page/checkout.php');
	exit;
}


