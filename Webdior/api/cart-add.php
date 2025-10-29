<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/security.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo json_encode(['success' => false, 'message' => 'Method not allowed']);
	exit;
}

$csrf = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null);
if (!csrf_validate_token($csrf, 'cart')) {
	echo json_encode(['success' => false, 'message' => 'CSRF invalid']);
	exit;
}

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
	echo json_encode(['success' => false, 'requires_login' => true, 'message' => 'Vui lòng đăng nhập để sử dụng giỏ hàng']);
	exit;
}

$productId = (int)($_POST['product_id'] ?? 0);
$quantity = max(1, (int)($_POST['quantity'] ?? 1));
if ($productId <= 0) {
	echo json_encode(['success' => false, 'message' => 'Thiếu product_id']);
	exit;
}

// Kiểm tra sản phẩm tồn tại và còn hàng
$product = fetchOne("SELECT id FROM products WHERE id = ? AND is_active = 1", [$productId]);
if (!$product) {
	echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
	exit;
}

try {
	// Nếu đã có, cập nhật số lượng; nếu chưa có thì insert
	$exists = fetchOne("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?", [$userId, $productId]);
	if ($exists) {
		executeStatement("UPDATE cart_items SET quantity = quantity + ?, updated_at = NOW() WHERE id = ?", [$quantity, $exists['id']]);
	} else {
		executeStatement("INSERT INTO cart_items (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())", [$userId, $productId, $quantity]);
	}

	$cntRow = fetchOne(
		"SELECT SUM(quantity) AS cnt FROM cart_items WHERE user_id = ?",
		[$userId]
	);
	$count = (int)($cntRow['cnt'] ?? 0);
	echo json_encode(['success' => true, 'count' => $count]);
} catch (Exception $e) {
	echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống']);
}


