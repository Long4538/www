<?php
session_start();
require_once '../admincp/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Giới Thiệu - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===== Bootstrap CSS & Icons ===== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/gioithieu.css">
</head>

<body>

  <!-- 🌸 ẢNH NỀN -->
  <div class="image-background"></div>

  <div class="site-content">

    <!-- ========== TOP BAR ========== -->
    <div class="bg-brand text-light py-2">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>

        <div class="d-flex gap-3 align-items-center">
          <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == '1'): ?>
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
            <li class="nav-item"><a class="nav-link active text-brand" href="gioithieu.php">Giới thiệu</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Nước hoa</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="nuochoanam.php">Nước hoa Nam</a></li>
                <li><a class="dropdown-item" href="nuochoanu.php">Nước hoa Nữ</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="khuyenmai.php">Khuyến mãi</a></li>
            <li class="nav-item"><a class="nav-link" href="phukien.php">Phụ kiện</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Hoạt động</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="khachhang.php">Khách hàng của DA</a></li>
                <li><a class="dropdown-item" href="camnhankhachhang.php">Cảm nhận của khách hàng</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="vechungtoi.php">Về chúng tôi</a></li>
            <li class="nav-item"><a class="nav-link" href="lienhe.php">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- ========== HERO SECTION ========== -->
    <section class="py-5 text-center text-white bg-opacity-75">
      <div class="container">
        <h1 class="fw-bold mb-3 text-shadow">Giới Thiệu Về Shop Nước Hoa DA</h1>
        <p class="lead">Nơi tôn vinh mùi hương – khơi gợi cá tính riêng của bạn.</p>
      </div>
    </section>

    <!-- ========== NỘI DUNG GIỚI THIỆU ========== -->
    <section class="py-5 bg-light bg-opacity-75">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="../Images/logo/gioithieu.jpg" alt="Giới thiệu" class="img-fluid rounded shadow">
          </div>
          <div class="col-md-6">
            <h2 class="fw-bold text-brand mb-3">Về cửa hàng</h2>
            <p>Shop Nước Hoa <strong>DA</strong> được thành lập với sứ mệnh mang đến cho khách hàng những mùi hương tinh tế, sang trọng và thể hiện phong cách riêng biệt. Chúng tôi cam kết cung cấp sản phẩm chính hãng 100%, nhập khẩu từ các thương hiệu danh tiếng như Dior, Chanel, Gucci, Versace,...</p>
            <p>Với đội ngũ tư vấn viên chuyên nghiệp, thân thiện, chúng tôi luôn sẵn sàng giúp bạn lựa chọn loại nước hoa phù hợp với cá tính, sở thích và hoàn cảnh sử dụng.</p>
            <a href="khuyenmai.php" class="btn btn-brand mt-3">Khám phá khuyến mãi</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== CAM KẾT ========== -->
    <section class="py-5 text-center text-light" style="background: linear-gradient(135deg, #b85a9b, #e06287);">
      <div class="container">
        <h2 class="fw-bold mb-4">Cam Kết Của Chúng Tôi</h2>
        <div class="row g-4">
          <div class="col-md-4">
            <i class="bi bi-shield-check display-5"></i>
            <h5 class="mt-3">Hàng Chính Hãng</h5>
            <p>100% sản phẩm được nhập khẩu chính ngạch, đầy đủ tem nhãn và hóa đơn.</p>
          </div>
          <div class="col-md-4">
            <i class="bi bi-truck display-5"></i>
            <h5 class="mt-3">Giao Hàng Toàn Quốc</h5>
            <p>Miễn phí vận chuyển cho đơn hàng từ 1.000.000đ, giao nhanh trong 2-3 ngày.</p>
          </div>
          <div class="col-md-4">
            <i class="bi bi-emoji-smile display-5"></i>
            <h5 class="mt-3">Hài Lòng 100%</h5>
            <p>Cam kết hoàn tiền nếu phát hiện hàng giả hoặc sản phẩm lỗi từ nhà sản xuất.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-values text-center">
      <div class="container">
        <h2>Giá Trị Cốt Lõi Của Shop DA</h2>
        <div class="row g-4">
          <div class="col-md-3">
            <i class="bi bi-heart display-5"></i>
            <h6 class="mt-3 fw-bold">Tận Tâm</h6>
            <p class="small text-muted">Mỗi sản phẩm là một sự chọn lọc kỹ lưỡng dành cho khách hàng.</p>
          </div>
          <div class="col-md-3">
            <i class="bi bi-stars display-5"></i>
            <h6 class="mt-3 fw-bold">Chất Lượng</h6>
            <p class="small text-muted">Cam kết sản phẩm chính hãng – mùi hương đẳng cấp.</p>
          </div>
          <div class="col-md-3">
            <i class="bi bi-people display-5"></i>
            <h6 class="mt-3 fw-bold">Khách Hàng Là Trọng Tâm</h6>
            <p class="small text-muted">Lắng nghe, thấu hiểu và phục vụ tận tình mọi nhu cầu.</p>
          </div>
          <div class="col-md-3">
            <i class="bi bi-globe display-5"></i>
            <h6 class="mt-3 fw-bold">Vươn Tầm Quốc Tế</h6>
            <p class="small text-muted">Không ngừng đổi mới – mang mùi hương Việt vươn xa.</p>
          </div>
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

  <!-- ===== Bootstrap JS ===== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 80) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
  </script>

</body>
</html>
