<?php
// =============================
// ✅ File: add_to_cart.php
// Nhiệm vụ: Lưu sản phẩm vào giỏ hàng (session) khi bấm “Thêm vào giỏ”
// =============================

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'admincp/config.php'; // Kết nối CSDL

// 🔒 Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('⚠️ Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        window.location.href = 'Pages/dangnhap.php';
    </script>";
    exit;
}

// ✅ Lấy id sản phẩm khi người dùng bấm nút
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ✅ Nếu id hợp lệ thì mới thêm vào giỏ
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Nếu giỏ hàng chưa có -> tạo mới
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm đã tồn tại trong giỏ -> tăng số lượng
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            // Nếu sản phẩm chưa có trong giỏ -> thêm vào
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['images'],
                'quantity' => 1
            ];
        }
    }
}

// ✅ Quay lại trang trước (index.php hoặc trang sản phẩm)
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
