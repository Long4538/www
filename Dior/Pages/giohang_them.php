<?php
session_start();
require_once '../admincp/config.php';

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        window.location.href = '../Pages/dangnhap.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Lấy dữ liệu từ form
$product_id = intval($_POST['id'] ?? 0);
$variant_id = intval($_POST['variant_id'] ?? 0);
$quantity = max(1, intval($_POST['quantity'] ?? 1));

if ($product_id <= 0) {
    header('Location: ../index.php');
    exit;
}

// ✅ Lấy thông tin sản phẩm
$stmt = $pdo->prepare("
    SELECT p.*, pi.src AS image_src 
    FROM products p 
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.id = :id
");
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ../index.php');
    exit;
}

$price = floatval($product['price']);

// ✅ Tìm hoặc tạo giỏ hàng của người dùng
$stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cart) {
    // 🔹 Nếu chưa có giỏ hàng → tạo mới
    $stmt = $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $pdo->lastInsertId();
} else {
    $cart_id = $cart['id'];
}

// ✅ Kiểm tra xem sản phẩm đã có trong giỏ chưa
$stmt = $pdo->prepare("
    SELECT id, quantity 
    FROM cart_items 
    WHERE cart_id = ? AND product_id = ? AND (variant_id = ? OR ? = 0)
");
$stmt->execute([$cart_id, $product_id, $variant_id, $variant_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    // 🔹 Nếu đã có thì cộng thêm số lượng
    $new_quantity = $item['quantity'] + $quantity;
    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->execute([$new_quantity, $item['id']]);
} else {
    // 🔹 Nếu chưa có thì thêm mới
    $stmt = $pdo->prepare("
        INSERT INTO cart_items (cart_id, product_id, variant_id, quantity, price)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$cart_id, $product_id, $variant_id ?: null, $quantity, $price]);
}

// ✅ Chuyển hướng đến giỏ hàng
header('Location: giohang.php');
exit;
?>
