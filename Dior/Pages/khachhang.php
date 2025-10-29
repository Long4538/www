<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Khách hàng của DA - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===== Bootstrap CSS & Icons ===== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">
</head>

<body>

  <!-- 🎬 VIDEO NỀN -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <div class="site-content">

    <!-- ========== TOP BAR ========== -->
    <div class="bg-brand text-light py-2">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
        <div class="d-flex gap-3">
          <a href="#" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
          <a href="#" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng xuất</a>
          <a href="#" class="text-light text-decoration-none"><i class="bi bi-cart"></i> Giỏ hàng</a>
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

    <!-- ========== NAVBAR MENU ========== -->
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Nước hoa</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="nuochoanam.php">Nước hoa Nam</a></li>
                <li><a class="dropdown-item" href="nuochoanu.php">Nước hoa Nữ</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="khuyenmai.php">Khuyến mãi</a></li>
            <li class="nav-item"><a class="nav-link" href="phukien.php">Phụ kiện</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">Hoạt động</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item active" href="../Pages/khachhang.php">Khách hàng của DA</a></li>
                <li><a class="dropdown-item" href="camnhankhachhang.php">Cảm nhận của khách hàng</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Về chúng tôi</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- ========== PHẦN KHÁCH HÀNG ========== -->
    <section class="py-5">
      <div class="container text-center text-white">
        <h2 class="fw-bold mb-4 text-shadow">Khách hàng của DA</h2>
        <p class="lead mb-5">Cảm ơn hơn <span class="text-warning">10.000+</span> khách hàng đã tin tưởng và đồng hành cùng DA Perfume trong suốt thời gian qua!</p>

        <div class="row g-4">
          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh1.jpg" class="card-img-top" alt="Khách hàng 1">
              <div class="card-body">
                <h5 class="card-title">Anh Minh - Doanh nhân</h5>
                <p class="card-text text-muted">"Tôi đã sử dụng Dior Sauvage ở đây, mùi hương tinh tế, bền lâu và dịch vụ cực kỳ chuyên nghiệp."</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh2.jpg" class="card-img-top" alt="Khách hàng 2">
              <div class="card-body">
                <h5 class="card-title">Chị Linh - Nhân viên văn phòng</h5>
                <p class="card-text text-muted">"Gucci Bloom ở đây chuẩn mùi chính hãng, đóng gói đẹp và giao hàng siêu nhanh!"</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh3.jpg" class="card-img-top" alt="Khách hàng 3">
              <div class="card-body">
                <h5 class="card-title">Bạn Huy - Sinh viên</h5>
                <p class="card-text text-muted">"Giá tốt, tư vấn cực kỳ nhiệt tình. Rất hài lòng khi mua hàng tại DA!"</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mt-4">
          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh4.jpg" class="card-img-top" alt="Khách hàng 4">
              <div class="card-body">
                <h5 class="card-title">Anh Quân - Nghệ sĩ</h5>
                <p class="card-text text-muted">"Đội ngũ chăm sóc khách hàng rất chuyên nghiệp. Tôi luôn được gợi ý đúng loại nước hoa phù hợp."</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh5.jpg" class="card-img-top" alt="Khách hàng 5">
              <div class="card-body">
                <h5 class="card-title">Chị Mai - Nhà thiết kế</h5>
                <p class="card-text text-muted">"Mình rất thích cách DA đóng gói và chăm chút từng đơn hàng, sang trọng và tinh tế."</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-lg">
              <img src="../Images/khachhang/kh6.jpg" class="card-img-top" alt="Khách hàng 6">
              <div class="card-body">
                <h5 class="card-title">Anh Tuấn - Doanh nhân</h5>
                <p class="card-text text-muted">"Một địa chỉ đáng tin cậy để mua nước hoa chính hãng tại Việt Nam."</p>
              </div>
            </div>
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

  </div>

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
