<?php
session_start();
require '../admincp/config.php';

// 🔒 Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Vui lòng đăng nhập để thực hiện thao tác này!');
        window.location.href = 'dangnhap.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Kiểm tra ID sản phẩm
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
        alert('Không tìm thấy sản phẩm để xóa!');
        window.location.href = 'giohang.php';
    </script>";
    exit;
}

$item_id = intval($_GET['id']);

// ✅ Xóa sản phẩm khỏi giỏ hàng (chỉ của user hiện tại)
$stmt = $pdo->prepare("
    DELETE ci FROM cart_items ci
    JOIN carts c ON ci.cart_id = c.id
    WHERE ci.id = ? AND c.user_id = ?
");
$stmt->execute([$item_id, $user_id]);

echo "<script>
    alert('🗑️ Đã xóa sản phẩm khỏi giỏ hàng!');
    window.location.href = 'giohang.php';
</script>";
exit;
?>
