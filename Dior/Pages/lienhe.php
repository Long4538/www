<?php
session_start();
require '../admincp/config.php'; // Đường dẫn đến config.php đúng

// Đếm số lượng sản phẩm trong giỏ hàng
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

// Thông tin user
$user_name = $_SESSION['user_name'] ?? null;
$role_id   = $_SESSION['role_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Liên hệ | Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    body {
      background: linear-gradient(135deg, #ffe4ec 0%, #fff1f5 50%, #fce4ec 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .site-content { position: relative; z-index: 2; }
    .content-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
      margin-bottom: 40px;
      text-align: center;
    }

    h2, h4 { color: #d64f72; }
    .btn-brand { background-color: #e88ea2; color: white; border: none; transition: 0.3s; }
    .btn-brand:hover { background-color: #d6738d; color: white; }
    p { font-size: 1.1rem; }
  </style>
</head>
<body>

<div class="site-content">

  <!-- ===== TOP BAR ===== -->
  <div class="bg-brand text-light py-2">
    <div class="container d-flex justify-content-between align-items-center small">
      <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
      <div class="d-flex gap-3 align-items-center">
        <?php if ($role_id == 1): ?>
          <a href="../admincp/admin.php" class="text-warning fw-bold">Quản trị</a>
        <?php endif; ?>

        <?php if ($user_name): ?>
          <span>Xin chào, <strong><?= htmlspecialchars($user_name) ?></strong>!</span>
          <a href="taikhoan.php" class="text-light text-decoration-none"><i class="bi bi-person-circle"></i> Tài khoản</a>
          <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        <?php else: ?>
          <a href="dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
        <?php endif; ?>

        <a href="giohang.php" class="text-light text-decoration-none position-relative">
          <i class="bi bi-cart"></i> Giỏ hàng
          <?php if ($cart_count > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?= $cart_count ?>
            </span>
          <?php endif; ?>
        </a>
      </div>
    </div>
  </div>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-brand" href="../index.php">Trang chủ</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="gioithieu.php">Giới thiệu</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Nước hoa</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="nuochoanam.php">Nước hoa Nam</a></li>
              <li><a class="dropdown-item" href="nuochoanu.php">Nước hoa Nữ</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="khuyenmai.php">Khuyến mãi</a></li>
          <li class="nav-item"><a class="nav-link" href="phukien.php">Phụ kiện</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Hoạt động</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="khachhang.php">Khách hàng của DA</a></li>
              <li><a class="dropdown-item" href="camnhankhachhang.php">Cảm nhận khách hàng</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="vechungtoi.php">Về chúng tôi</a></li>
          <li class="nav-item"><a class="nav-link active" href="lienhe.php">Liên hệ</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ===== NỘI DUNG LIÊN HỆ ===== -->
  <section class="py-5">
    <div class="container content-card">
      <h2 class="fw-bold mb-4">Thông tin liên hệ</h2>
      <p>📧 Email: <strong>contact@nuochoada.vn</strong></p>
      <p>📞 Hotline: <strong>0989 123 456</strong></p>
      <p>🏢 Địa chỉ: <strong>123 Nguyễn Trãi, TP.HCM</strong></p>
      <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7!</p>

      <div class="mt-4">
        <a href="../index.php" class="btn btn-brand"><i class="bi bi-house"></i> Quay lại trang chủ</a>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="pt-5 pb-3 text-center text-white">
    <div class="container">
      <p>© 2025 Shop Nước Hoa DA - Tỏa sáng cùng hương thơm 🌸</p>
    </div>
  </footer>

</div><!-- END site-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
