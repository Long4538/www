<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$order = $_SESSION['order_info'] ?? null;

if (!$order) {
    header("Location: giohang.php");
    exit;
}
?>

<link rel="stylesheet" href="../view/css/success.css">

<div class="success__container fade-in">
    <div class="success__card">
        <div class="success__icon">✅</div>
        <h2>Đặt hàng thành công!</h2>
        <p>Mã đơn hàng của bạn là <strong>#<?= $order['id'] ?></strong></p>
        <p>Tổng tiền: <strong><?= number_format($order['total']) ?>đ</strong></p>
        <p>Xin cảm ơn <?= htmlspecialchars($order['name']) ?> đã mua sắm tại YouPort.vn!</p>
        <a href="../controller/index.php" class="btn btn-view">← Quay lại trang chủ</a>
        <a href="../controller/index.php?act=donhang" class="btn btn-view">📦 Xem đơn hàng</a>
    </div>
</div>
