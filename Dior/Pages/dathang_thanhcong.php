<?php
session_start();
require '../admincp/config.php';

$order_id = $_GET['order_id'] ?? 0;
if (!$order_id) {
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt hàng thành công - Shop Nước Hoa DA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container text-center py-5">
    <div class="card shadow p-4">
      <h2 class="text-success mb-3"><i class="bi bi-check-circle"></i> Đặt hàng thành công!</h2>
      <p>Cảm ơn bạn <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Khách hàng') ?></strong> đã đặt hàng tại <b>Shop Nước Hoa DA</b>.</p>
      <p>Mã đơn hàng của bạn là: <strong>#<?= htmlspecialchars($order['order_number'] ?? $order['id']) ?></strong></p>
      <p>Tổng tiền: <span class="text-danger fw-bold"><?= number_format($order['total'], 0, ',', '.') ?>đ</span></p>
      <p>Chúng tôi sẽ xác nhận đơn hàng sớm nhất.</p>
      <a href="../index.php" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
    </div>
  </div>
</body>
</html>
