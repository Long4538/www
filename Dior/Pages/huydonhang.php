<?php
session_start();
require '../admincp/config.php';

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: dangnhap.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GET['id'] ?? 0);

// ✅ Kiểm tra xem đơn có thuộc người dùng & có thể hủy không
$stmt = $pdo->prepare("
    SELECT * FROM orders 
    WHERE id = ? AND user_id = ? AND status IN ('pending', 'processing')
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<script>
        alert('❌ Không thể hủy đơn hàng này!');
        window.location.href = 'user_order.php';
    </script>";
    exit;
}

// ✅ Cập nhật trạng thái sang 'cancelled'
$update = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
$update->execute([$order_id]);

echo "<script>
    alert('🗑️ Đơn hàng của bạn đã được hủy thành công!');
    window.location.href = 'user_order.php';
</script>";
exit;
?>
