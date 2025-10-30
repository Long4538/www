<?php
session_start();
require 'admincp/config.php';

// ✅ Hiển thị lỗi chi tiết (chỉ nên bật khi test)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('⚠️ Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        window.location.href = 'Pages/dangnhap.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die("❌ Lỗi: Không có ID sản phẩm hợp lệ");
}

// ✅ Lấy thông tin sản phẩm (có ảnh nếu cần)
$stmt = $pdo->prepare("
    SELECT p.id, p.name, p.price, pi.src AS image_src
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.id = ?
");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("❌ Không tìm thấy sản phẩm trong CSDL");
}

// ✅ Tìm hoặc tạo giỏ hàng của người dùng
$stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cart) {
    // 🟢 Nếu chưa có → tạo mới
    $stmt = $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $pdo->lastInsertId();
} else {
    $cart_id = $cart['id'];
}

// ✅ Kiểm tra sản phẩm đã có trong giỏ chưa
$stmt = $pdo->prepare("
    SELECT id, quantity 
    FROM cart_items 
    WHERE cart_id = ? AND product_id = ? AND (variant_id IS NULL OR variant_id = 0)
");
$stmt->execute([$cart_id, $product_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    // 🟡 Nếu đã có → tăng số lượng
    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE id = ?");
    $stmt->execute([$item['id']]);
} else {
    // 🟢 Nếu chưa có → thêm mới
    $stmt = $pdo->prepare("
        INSERT INTO cart_items (cart_id, product_id, variant_id, quantity, price)
        VALUES (?, ?, NULL, 1, ?)
    ");
    $stmt->execute([$cart_id, $product_id, $product['price']]);
}

// ✅ Chuyển hướng về giỏ hàng
header("Location: Pages/giohang.php");
exit;
?>
