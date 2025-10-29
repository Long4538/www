<?php
session_start();
require '../admincp/config.php';

// Lấy sản phẩm phụ kiện từ database
$stmt = $pdo->query("
    SELECT p.*, pi.src AS image_src
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.is_active = 1 AND p.short_description LIKE '%phụ kiện%'
    ORDER BY p.id DESC
");
$accessories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm số lượng sản phẩm trong giỏ hàng
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Phụ Kiện - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===== Bootstrap CSS & Icons ===== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    .card-img-top {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<!-- ========== TOP BAR ========== -->
<div class="bg-brand text-light py-2">
  <div class="container d-flex justify-content-between align-items-center small">
    <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
    <div class="d-flex gap-3 align-items-center">
      <?php if (isset($_SESSION['user_name'])): ?>
        <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
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

<!-- ========== HEADER ========== -->
<header class="py-3 bg-light border-bottom">
  <div class="container d-flex flex-wrap justify-content-between align-items-center">
    <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
      <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
    </a>

    <form class="d-flex flex-grow-1 mx-3" role="search">
      <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
      <button class="btn btn-brand" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <div class="text-end">
      <p class="mb-0 fw-bold text-secondary">
        <i class="bi bi-telephone"></i> Hotline: <span class="text-danger">0989 123 456</span>
      </p>
      <small class="text-muted">Hỗ trợ 24/7</small>
    </div>
  </div>
</header>

<!-- ========== NAVBAR CHUNG ======= -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-brand" href="../index.php">Trang chủ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="../Pages/gioithieu.php">Giới thiệu</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Nước hoa</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../Pages/nuochoanam.php">Nước hoa Nam</a></li>
            <li><a class="dropdown-item" href="../Pages/nuochoanu.php">Nước hoa Nữ</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="../Pages/khuyenmai.php">Khuyến mãi</a></li>
        <li class="nav-item"><a class="nav-link active text-brand fw-bold" href="../Pages/phukien.php">Phụ kiện</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Hoạt động</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../Pages/khachhang.php">Khách hàng của DA</a></li>
            <li><a class="dropdown-item" href="../Pages/camnhankhachhang.php">Cảm nhận khách hàng</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="../Pages/vechungtoi.php">Về chúng tôi</a></li>
        <li class="nav-item"><a class="nav-link" href="../Pages/lienhe.php">Liên hệ</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ========== HERO PHỤ KIỆN ========== -->
<section class="py-5 text-center text-light bg-dark bg-opacity-50" 
         style="background: url('../Images/backgrounds/accessories-bg.jpg') center/cover no-repeat; position: relative;">
  <div class="container position-relative" style="z-index: 2;">
    <h1 class="fw-bold display-5">Phụ Kiện Dior</h1>
    <p class="lead">Tôn vinh phong cách – Hoàn thiện sự tinh tế cùng Dior.</p>
  </div>
  <div class="overlay"></div>
</section>

<!-- ========== DANH SÁCH PHỤ KIỆN ========== -->
<section class="py-5 text-center">
  <div class="container">
    <h2 class="fw-bold mb-4 text-brand">Bộ Sưu Tập Phụ Kiện Nổi Bật</h2>
    <div class="row g-4">
      <?php if ($accessories): ?>
        <?php foreach ($accessories as $item): ?>
          <?php 
            $img_path = !empty($item['image_src']) ? "../" . ltrim($item['image_src'], "/") : '../Images/phukien/no-images.jpg';
          ?>
          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow">
              <img src="<?= htmlspecialchars($img_path) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
              <div class="card-body">
                <h5 class="card-title fw-bold"><?= htmlspecialchars($item['name']) ?></h5>
                <p class="card-text text-muted"><?= htmlspecialchars($item['short_description']) ?></p>
                <div class="d-flex justify-content-center gap-2 mt-2">
                  <a href="muangay.php?id=<?= $item['id'] ?>" class="btn btn-brand btn-sm">Mua ngay</a>
                  <a href="add_to_cart.php?id=<?= $item['id'] ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-cart"></i> Giỏ hàng
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-muted">Hiện chưa có sản phẩm phụ kiện.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="pt-5 pb-3">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Về chúng tôi</h5>
        <p>Shop Nước Hoa DA cung cấp các dòng nước hoa chính hãng, giúp bạn tự tin và tỏa sáng mỗi ngày.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Chính sách</h5>
        <ul class="list-unstyled">
          <li><a href="#">Chính sách đổi trả</a></li>
          <li><a href="#">Bảo mật thông tin</a></li>
          <li><a href="#">Giao hàng toàn quốc</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Liên hệ</h5>
        <p><i class="bi bi-geo-alt"></i> 123 Nguyễn Trãi, TP.HCM</p>
        <p><i class="bi bi-envelope"></i> contact@nuochoada.vn</p>
        <p><i class="bi bi-telephone"></i> 0989 123 456</p>
      </div>
    </div>
    <div class="border-top pt-3 text-center">
      <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 80) navbar.classList.add('scrolled');
  else navbar.classList.remove('scrolled');
});
</script>

</body>
</html>
