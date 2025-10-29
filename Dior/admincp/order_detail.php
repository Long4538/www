<?php
session_start();
require_once 'config.php';

// ✅ Kiểm tra quyền admin
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../Index.php');
    exit;
}

// ✅ Lấy ID đơn hàng từ URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($order_id <= 0) {
    header("Location: orders_list.php");
    exit;
}

// ✅ Lấy thông tin đơn hàng
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<h3 class='text-center text-danger mt-5'>Không tìm thấy đơn hàng!</h3>";
    exit;
}

// ✅ Lấy danh sách sản phẩm trong đơn hàng
$itemStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$itemStmt->execute([$order_id]);
$order_items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-lg p-4">
    <h2 class="text-primary mb-4">🧾 Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>

    <?php if (isset($_GET['updated'])): ?>
      <div class="alert alert-success">✅ Trạng thái đơn hàng đã được cập nhật thành công!</div>
    <?php endif; ?>

    <div class="row mb-4">
      <div class="col-md-6">
        <h5 class="fw-bold">Thông tin đơn hàng</h5>
        <ul class="list-unstyled">
          <li><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($order['order_number']) ?></li>
          <li><strong>Khách hàng ID:</strong> <?= htmlspecialchars($order['user_id']) ?></li>
          <li><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['shipping_address']) ?></li>
          <li><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></li>
          <li><strong>Ngày tạo:</strong> <?= htmlspecialchars($order['created_at']) ?></li>
        </ul>
      </div>

      <div class="col-md-6">
        <h5 class="fw-bold">Trạng thái đơn hàng</h5>
        <form action="order_update.php" method="POST" class="mt-2">
          <input type="hidden" name="id" value="<?= $order['id'] ?>">

          <select name="status" class="form-select w-75">
            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>⏳ Chờ xác nhận</option>
            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>✅ Đã xác nhận</option>
            <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>💰 Đã thanh toán</option>
            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>🚚 Đã giao hàng</option>
            <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>🏆 Hoàn tất</option>
            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>❌ Đã hủy</option>
          </select>

          <button type="submit" class="btn btn-success mt-3 px-4">
            <i class="bi bi-check2-circle"></i> Cập nhật
          </button>
        </form>
      </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <h5 class="fw-bold mt-4">📦 Sản phẩm trong đơn</h5>
    <table class="table table-bordered mt-3 align-middle">
      <thead class="table-secondary text-center">
        <tr>
          <th>#</th>
          <th>Tên sản phẩm</th>
          <th>Mã SKU</th>
          <th>Số lượng</th>
          <th>Đơn giá</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($order_items)): ?>
          <?php foreach ($order_items as $index => $item): ?>
            <tr>
              <td class="text-center"><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($item['product_name']) ?></td>
              <td class="text-center"><?= htmlspecialchars($item['sku'] ?? '-') ?></td>
              <td class="text-center"><?= $item['quantity'] ?></td>
              <td class="text-end"><?= number_format($item['unit_price'], 0, ',', '.') ?>đ</td>
              <td class="text-end"><?= number_format($item['total_price'], 0, ',', '.') ?>đ</td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center text-muted">Không có sản phẩm trong đơn hàng.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="text-end mt-3">
      <h5>Tổng cộng: <span class="text-danger fw-bold"><?= number_format($order['total'], 0, ',', '.') ?>đ</span></h5>
    </div>

    <div class="mt-4 text-center">
      <a href="orders.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách đơn hàng
      </a>
    </div>
  </div>
</div>

</body>
</html>
