<?php
// -----------------------------------------
// 🔹 Bắt đầu session để kiểm tra đăng nhập
// -----------------------------------------
session_start();
require_once 'config.php'; // Gọi file kết nối cơ sở dữ liệu

// -----------------------------------------
// 🔹 Kiểm tra xem có phải admin không
// Nếu chưa đăng nhập hoặc không phải role_id = 1 (admin)
// thì quay lại trang đăng nhập
// -----------------------------------------
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../Pages/dangnhap.php');
    exit;
}

// Lấy tên admin từ session để chào
$admin_name = $_SESSION['user_name'] ?? 'Admin';

// -----------------------------------------
// 🔹 Lấy 5 đơn hàng gần nhất (join với bảng users)
// -----------------------------------------
$stmtOrders = $pdo->query("
    SELECT o.id, o.order_number, o.status, o.total, o.created_at, u.full_name AS customer_name
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 5
");
$recent_orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

// -----------------------------------------
// 🔹 Lấy 5 thông báo mới nhất từ bảng notifications (nếu có)
// -----------------------------------------
$stmtNotify = $pdo->query("
    SELECT n.*, u.full_name AS user_name
    FROM notifications n
    LEFT JOIN users u ON n.user_id = u.id
    ORDER BY n.created_at DESC
    LIMIT 5
");
$notifications = $stmtNotify->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang Quản Trị</title>

  <!-- Bootstrap & Icon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- ====================== GIAO DIỆN CHÍNH ====================== -->
<div class="container py-5">

  <!-- ✅ Phần chào mừng admin -->
  <div class="mb-4 text-center">
    <h1 class="text-primary">Xin chào, <?= htmlspecialchars($admin_name) ?>!</h1>
    <p class="lead">Chào mừng bạn đến với <strong>Trang Quản Trị Dior Perfume</strong>.</p>
    <a href="logout.php" class="btn btn-outline-danger btn-sm">
      <i class="bi bi-box-arrow-right"></i> Đăng xuất
    </a>
  </div>

  <!-- ✅ Thống kê nhanh -->
  <div class="row text-center mb-4">

    <!-- Tổng số người dùng -->
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5><i class="bi bi-people"></i> Người dùng</h5>
        <p class="fs-4 fw-bold text-primary">
          <?= $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() ?>
        </p>
      </div>
    </div>

    <!-- Tổng số đơn hàng -->
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5><i class="bi bi-bag-check"></i> Đơn hàng</h5>
        <p class="fs-4 fw-bold text-success">
          <?= $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() ?>
        </p>
      </div>
    </div>

    <!-- Tổng số thông báo -->
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5><i class="bi bi-bell"></i> Thông báo</h5>
        <p class="fs-4 fw-bold text-warning">
          <?= $pdo->query("SELECT COUNT(*) FROM notifications")->fetchColumn() ?>
        </p>
      </div>
    </div>
  </div>

  <!-- ✅ Bảng Đơn hàng mới nhất -->
  <div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-truck"></i> Đơn hàng mới nhất
    </div>

    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Mã đơn hàng</th>
            <th>Khách hàng</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th>Ngày tạo</th>
          </tr>
        </thead>

        <tbody>
          <?php if ($recent_orders): ?>
            <?php foreach ($recent_orders as $index => $order): ?>
              <tr class="align-middle text-center">
                <!-- STT -->
                <td><?= $index + 1 ?></td>

                <!-- Mã đơn hàng (click để xem chi tiết) -->
                <td>
                  <a href="order_detail.php?id=<?= $order['id'] ?>">#<?= htmlspecialchars($order['order_number']) ?></a>
                </td>

                <!-- Tên khách hàng -->
                <td><?= htmlspecialchars($order['customer_name'] ?? 'Không rõ') ?></td>

                <!-- Trạng thái với màu sắc -->
                <td>
                  <?php
                    // Gán màu tương ứng với từng trạng thái
                    $status_labels = [
                      'pending' => 'secondary',   // Chờ xác nhận
                      'processing' => 'info',     // Đã xác nhận
                      'paid' => 'success',        // Đã thanh toán
                      'shipped' => 'warning',     // Đã giao hàng
                      'cancelled' => 'danger'     // Đã hủy
                    ];
                    $label = $status_labels[$order['status']] ?? 'secondary';
                  ?>
                  <span class="badge bg-<?= $label ?>">
                    <?= htmlspecialchars($order['status']) ?>
                  </span>
                </td>

                <!-- Tổng tiền -->
                <td class="text-end"><?= number_format($order['total'], 0, ',', '.') ?>đ</td>

                <!-- Ngày tạo -->
                <td><?= $order['created_at'] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Không có đơn hàng nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ✅ Thông báo gần đây -->
  <div class="card shadow-lg">
    <div class="card-header bg-warning">
      <i class="bi bi-bell-fill"></i> Thông báo gần đây
    </div>

    <ul class="list-group list-group-flush">
      <?php if ($notifications): ?>
        <?php foreach ($notifications as $note): ?>
          <li class="list-group-item">
            <!-- Hiển thị người gửi + nội dung thông báo -->
            <strong><?= htmlspecialchars($note['user_name'] ?? 'Người dùng') ?>:</strong>
            <?= htmlspecialchars($note['message']) ?>
            <br>
            <!-- Thời gian tạo -->
            <small class="text-muted"><?= $note['created_at'] ?></small>
          </li>
        <?php endforeach; ?>
      <?php else: ?>
        <li class="list-group-item text-muted text-center">
          Chưa có thông báo nào.
        </li>
      <?php endif; ?>
    </ul>
  </div>

</div>
</body>
</html>
