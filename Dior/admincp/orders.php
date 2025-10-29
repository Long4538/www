<?php
session_start();
require_once 'config.php';

// Chỉ cho phép admin truy cập
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../Index.php');
    exit;
}

// Lọc và tìm kiếm
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// Lấy danh sách đơn hàng
$sql = "SELECT o.*, u.full_name AS customer_name 
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        WHERE 1";

$params = [];
if ($search !== '') {
    $sql .= " AND (o.order_number LIKE ? OR u.full_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($status !== '') {
    $sql .= " AND o.status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY o.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$status_list = [
    'pending' => 'Chờ xử lý',
    'processing' => 'Đang xử lý',
    'paid' => 'Đã thanh toán',
    'shipped' => 'Đang giao',
    'completed' => 'Hoàn tất',
    'cancelled' => 'Đã hủy',
    'refunded' => 'Hoàn tiền'
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3 class="text-center mb-4 text-uppercase text-primary">Quản lý đơn hàng</h3>
  <a href="../admincp/admin.php" class="btn btn-outline-secondary mb-3">⬅ Quay lại danh sách</a>
  <form method="get" class="row g-2 mb-3">
    <div class="col-md-4">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Tìm mã đơn hoặc tên khách hàng...">
    </div>
    <div class="col-md-3">
      <select name="status" class="form-select">
        <option value="">-- Tất cả trạng thái --</option>
        <?php foreach ($status_list as $key => $val): ?>
          <option value="<?= $key ?>" <?= $status === $key ? 'selected' : '' ?>><?= $val ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">Lọc</button>
    </div>
    <div class="col-md-2">
      <a href="orders.php" class="btn btn-secondary w-100">Làm mới</a>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center align-middle bg-white">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Mã đơn</th>
          <th>Khách hàng</th>
          <th>Trạng thái</th>
          <th>Tổng tiền (VNĐ)</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($orders): ?>
          <?php foreach ($orders as $i => $row): ?>
            <?php
              $badge = match($row['status']) {
                'pending' => 'warning',
                'processing' => 'info',
                'paid' => 'primary',
                'shipped', 'completed' => 'success',
                'cancelled' => 'danger',
                'refunded' => 'secondary',
                default => 'light'
              };
            ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= htmlspecialchars($row['order_number']) ?></td>
              <td><?= htmlspecialchars($row['customer_name'] ?? 'Khách lẻ') ?></td>
              <td><span class="badge bg-<?= $badge ?>"><?= $status_list[$row['status']] ?? $row['status'] ?></span></td>
              <td><?= number_format($row['total'], 0, ',', '.') ?></td>
              <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
              <td>
                <a href="order_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Chi tiết</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7">Không có đơn hàng nào.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
