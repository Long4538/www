<?php
session_start();
require '../admincp/config.php';

// Lấy danh sách sản phẩm khuyến mãi từ database
$stmt = $pdo->query("
    SELECT p.*, pi.src AS image_src
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.is_active = 1 AND p.is_promo = 1
    ORDER BY p.id DESC
");
$promo_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Khuyến Mãi - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===== Bootstrap CSS & Icons ===== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    body {
      background: url("../Images/nuochoa/khuyenmai.jpg") no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: -1;
    }
    .site-content { position: relative; z-index: 1; }
    .text-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.6); }
    .bg-brand { background-color: #d63384; }
    .btn-brand { background-color: #d63384; color: #fff; border: none; }
    .btn-brand:hover { background-color: #b11d68; color: #fff; }
    .text-brand { color: #d63384 !important; }
    .navbar.scrolled {
      background: rgba(255,255,255,0.95);
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
  </style>
</head>

<body>

<div class="site-content">

  <!-- ========== TOP BAR ========== -->
  <div class="bg-brand text-light py-2">
    <div class="container d-flex justify-content-between align-items-center small">
      <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
      <div class="d-flex gap-3 align-items-center">
        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
          <a href="../admincp/admin.php" class="text-warning fw-bold">Quản trị</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_name'])): ?>
          <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
          <a href="taikhoan.php" class="text-light text-decoration-none"><i class="bi bi-person-circle"></i> Tài khoản</a>
          <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        <?php else: ?>
          <a href="dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
        <?php endif; ?>

        <?php
        $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
        ?>
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

  <!-- ========== NAVBAR ========== -->
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
          <li class="nav-item"><a class="nav-link active text-brand" href="khuyenmai.php">Khuyến mãi</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/phukien.php">Phụ kiện</a></li>
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

  <!-- ========== HERO TITLE ========== -->
  <section class="py-5 text-center text-white">
    <div class="container">
      <h1 class="fw-bold mb-3 text-shadow">🎉 Chương Trình Khuyến Mãi 🎉</h1>
      <p class="lead">Nhanh tay sở hữu những mùi hương cao cấp với mức giá siêu ưu đãi!</p>
    </div>
  </section>

  <!-- ========== DANH SÁCH SẢN PHẨM KHUYẾN MÃI ========== -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <?php if ($promo_products): ?>
          <?php foreach ($promo_products as $sp): ?>
            <?php 
              $img_path = !empty($sp['image_src']) ? '../' . $sp['image_src'] : '../Images/nuochoa/no-images.jpg';
              $discount = $sp['promo_price'] > 0 ? round((($sp['price'] - $sp['promo_price']) / $sp['price']) * 100) : 0;
            ?>
            <div class="col-md-3 col-sm-6">
              <div class="card h-100 shadow-sm border-0">
                <img src="<?= htmlspecialchars($img_path) ?>" class="card-img-top rounded" alt="<?= htmlspecialchars($sp['name']) ?>" style="object-fit: cover; height: 250px;">
                <div class="card-body text-center">
                  <h5 class="card-title"><?= htmlspecialchars($sp['name']) ?></h5>
                  <p class="text-muted"><?= htmlspecialchars($sp['short_description']) ?></p>
                  <p class="text-muted"><del><?= number_format($sp['price'],0,',','.') ?>đ</del></p>
                  <p class="fw-bold text-danger"><?= number_format($sp['promo_price'],0,',','.') ?>đ</p>
                  <?php if ($discount > 0): ?>
                    <span class="badge bg-danger">-<?= $discount ?>%</span>
                  <?php endif; ?>
                  <div class="d-flex justify-content-center gap-2 mt-2">
                    <a href="muangay.php?id=<?= $sp['id'] ?>" class="btn btn-brand btn-sm">Mua ngay</a>
                    <a href="add_to_cart.php?id=<?= $sp['id'] ?>" class="btn btn-outline-secondary btn-sm">
                      <i class="bi bi-cart"></i> Giỏ hàng
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-light">Hiện chưa có sản phẩm khuyến mãi.</p>
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

</div><!-- END site-content -->

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
