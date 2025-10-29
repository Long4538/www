<?php
session_start();
require_once '../admincp/config.php';

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: dangnhap.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Lấy danh sách đơn hàng của người dùng
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đơn hàng của tôi | Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    /* 🌸 Video nền & overlay */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,182,193,0.3));
      z-index: 1;
    }

    /* 🌷 Nội dung chính */
    .orders-section {
      position: relative;
      z-index: 2;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .orders-card {
      background: rgba(255, 255, 255, 0.93);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
    }

    /* 🎀 Nút cùng tone */
    .btn-brand {
      background-color: #e88ea2;
      color: white;
      border: none;
      transition: 0.3s;
    }
    .btn-brand:hover {
      background-color: #d6738d;
      color: white;
    }

    /* 🌸 Bảng đơn hàng */
    table {
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.85);
    }
    th {
      background-color: #fce4ec !important;
    }

    /* 🎀 Badge tone nhẹ */
    .badge.bg-secondary { background-color: #bdbdbd !important; }
    .badge.bg-info { background-color: #81d4fa !important; color: #004d60 !important; }
    .badge.bg-success { background-color: #a5d6a7 !important; color: #1b5e20 !important; }
    .badge.bg-warning { background-color: #ffe082 !important; color: #795548 !important; }
    .badge.bg-danger { background-color: #ef9a9a !important; color: #880e4f !important; }

    .footer {
      background: rgba(0, 0, 0, 0.4);
      color: white;
      padding: 20px 0;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <!-- 🌸 Video nền -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <!-- 🌸 Overlay hồng phấn -->
  <div class="overlay"></div>

  <!-- ====== TOP BAR ====== -->
  <div class="bg-brand text-light py-2" style="z-index:3; position:relative;">
    <div class="container d-flex justify-content-between align-items-center small">
      <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
      <div class="d-flex gap-3">
        <a href="../index.php" class="text-light text-decoration-none"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="taikhoan.php" class="text-light text-decoration-none"><i class="bi bi-person-circle"></i> Tài khoản</a>
        <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
      </div>
    </div>
  </div>

  <!-- ====== DANH SÁCH ĐƠN HÀNG ====== -->
  <section class="orders-section">
    <div class="container">
      <div class="orders-card shadow-lg">
        <h2 class="text-center text-primary mb-4">
          <i class="bi bi-bag-check"></i> Đơn hàng của tôi
        </h2>

        <?php if ($orders): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
              <thead class="table-secondary">
                <tr>
                  <th>#</th>
                  <th>Mã đơn hàng</th>
                  <th>Trạng thái</th>
                  <th>Tổng tiền</th>
                  <th>Ngày đặt</th>
                  <th>Chi tiết</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orders as $index => $order): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td>#<?= htmlspecialchars($order['order_number']) ?></td>
                    <td>
                      <?php
                        $status_labels = [
                          'pending' => ['Chờ xác nhận', 'secondary'],
                          'processing' => ['Đã xác nhận', 'info'],
                          'paid' => ['Đã thanh toán', 'success'],
                          'shipped' => ['Đang giao hàng', 'warning'],
                          'completed'  => ['Hoàn tất', 'success'],
                          'cancelled' => ['Đã hủy', 'danger']
                        ];
                        $status = $status_labels[$order['status']] ?? ['Không rõ', 'dark'];
                      ?>
                      <span class="badge bg-<?= $status[1] ?>"><?= $status[0] ?></span>
                    </td>
                    <td class="text-end"><?= number_format($order['total'], 0, ',', '.') ?>đ</td>
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                    <td>
                      <a href="user_order_detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i> Xem
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Bạn chưa có đơn hàng nào.
          </div>
        <?php endif; ?>

        <div class="text-center mt-4">
          <a href="taikhoan.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại tài khoản
          </a>
          <a href="../index.php" class="btn btn-brand ms-2">
            <i class="bi bi-house"></i> Về trang chủ
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== FOOTER ====== -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 Shop Nước Hoa DA - Tỏa sáng cùng hương thơm 🌸</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
