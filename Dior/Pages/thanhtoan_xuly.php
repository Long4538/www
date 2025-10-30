<?php
session_start();
require '../admincp/config.php';

// ✅ 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_name'])) {
    header("Location: dangnhap.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;

// ✅ 2. Chỉ xử lý POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: thanhtoan.php");
    exit;
}

// ✅ 3. Nhận dữ liệu từ form
$fullname   = trim($_POST['fullname']);
$phone      = trim($_POST['phone']);
$address    = trim($_POST['address']);
$payment    = trim($_POST['payment']);
$product_id = $_POST['product_id'] ?? null;

// ✅ 4. Lấy giỏ hàng (session)
$cart = $_SESSION['cart'] ?? [];

// ✅ 5. Xác định sản phẩm cần thanh toán
$order_items = [];

if ($product_id) {
    // 🟢 Mua ngay
    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $order_items[] = [
            'id'       => $product['id'],
            'name'     => $product['name'],
            'price'    => $product['price'],
            'quantity' => 1
        ];
    }
} else {
    // 🟣 Thanh toán giỏ hàng
    foreach ($cart as $item) {
        $order_items[] = [
            'id'       => $item['id'],
            'name'     => $item['name'],
            'price'    => $item['price'],
            'quantity' => $item['quantity']
        ];
    }
}

// ✅ 6. Tính tổng tiền
$total_amount = 0;
foreach ($order_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

try {
    $pdo->beginTransaction();

    // ✅ 7. Tạo mã đơn hàng duy nhất
    $order_number = 'ORD' . date('YmdHis') . rand(1000, 9999);

    // ✅ 8. Lưu vào bảng orders
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, order_number, shipping_address, billing_address, payment_method, total, status, created_at)
        VALUES (:user_id, :order_number, :shipping_address, :billing_address, :payment_method, :total, :status, NOW())
    ");
    $stmt->execute([
        ':user_id'          => $user_id,
        ':order_number'     => $order_number,
        ':shipping_address' => $address,
        ':billing_address'  => $address,
        ':payment_method'   => $payment,
        ':total'            => $total_amount,
        ':status'           => 'pending'
    ]);

    $order_id = $pdo->lastInsertId();

    // ✅ 9. Lưu từng sản phẩm vào order_items
    $item_stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, total_price, created_at)
        VALUES (:order_id, :pid, :pname, :qty, :unit_price, :total_price, NOW())
    ");

    foreach ($order_items as $item) {
        $item_stmt->execute([
            ':order_id'   => $order_id,
            ':pid'        => $item['id'],
            ':pname'      => $item['name'],
            ':qty'        => $item['quantity'],
            ':unit_price' => $item['price'],
            ':total_price'=> $item['price'] * $item['quantity']
        ]);
    }

    // ✅ 10. Xóa giỏ hàng trong DB đúng cách
    $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cartRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartRow) {
        $cart_id = $cartRow['id'];

        // Xóa sản phẩm trong giỏ hàng
        $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?")->execute([$cart_id]);
        // Xóa giỏ hàng chính
        $pdo->prepare("DELETE FROM carts WHERE id = ?")->execute([$cart_id]);
    }

    // ✅ 11. Xóa giỏ hàng trong session
    unset($_SESSION['cart']);

    // ✅ 12. Hoàn tất
    $pdo->commit();

    header("Location: dathang_thanhcong.php?order_id=" . $order_id);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<h3 style='color:red; text-align:center;'>❌ Lỗi khi xử lý đơn hàng: " . htmlspecialchars($e->getMessage()) . "</h3>";
}
?>
