<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Menu Top CGV</title>
  <!-- Gọi file CSS chung -->
  <!-- <link rel="stylesheet" href="../Css/menu.css"> -->
  <link rel="stylesheet" href="../Css/style.css">
  <!-- Font Awesome để dùng icon (facebook, youtube, phone, email, ...) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Thanh menu top -->
  <nav class="topnav">
    <!-- Logo -->
    <div class="logo">
      <a href="../Index.php">
        <img src="../images/logo.png" alt="Logo CJ CGV">
      </a>
    </div>

    <!-- Các mục menu -->
    <ul>
      <li><a href="../Index.php">Trang chủ</a></li>
      <li><a href="../Page/phim.php">Phim</a></li>
      <li><a href="../Page/lienhe.php" class="active">Liên hệ</a></li>
      <li><a href="../Page/dangnhap.php">Đăng nhập</a></li>
      <li><a href="../Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>

  <!-- Khu vực Liên hệ -->
  <section class="contact-container">
    <!-- Form liên hệ -->
    <div class="contact-form">
  <h2>Liên hệ với chúng tôi</h2>
  <form id="contactForm">
    <label>Họ và tên:</label><br>
    <input type="text" id="name"><br><br>

    <label>Email:</label><br>
    <input type="text" id="email"><br><br>

    <label>Số điện thoại:</label><br>
    <input type="text" id="phone"><br><br>

    <label>Tiêu đề:</label><br>
    <input type="text" id="subject"><br><br>

    <label>Nội dung:</label><br>
    <textarea id="message"></textarea><br><br>

    <button type="submit">Gửi liên hệ</button>
  </form>
    </div>

    <!-- Thông tin liên hệ -->
    <div class="contact-info">
      <!-- Địa chỉ -->
      <div class="info-box">
        <h3>Địa chỉ</h3>
        <p>123 Đường Sắc Đẹp, Quận 1, TP. Hồ Chí Minh</p>
      </div>
      <!-- Điện thoại -->
      <div class="info-box">
        <h3>Điện thoại</h3>
        <p>0707 645 756</p>
      </div>
      <!-- Email -->
      <div class="info-box">
        <h3>Email</h3>
        <p>nguyenhuuha9091999@gmail.com</p>
      </div>
      <!-- Giờ làm việc -->
      <div class="info-box">
        <h3>Giờ làm việc</h3>
        <p>Thứ 2 - Thứ 6: 9:00 - 23:00</p>
        <p>Thứ 7 - Chủ nhật: 8:00 - 24:00</p>
      </div>
      <!-- Bản đồ Google Maps -->
      <div class="info-box map">
        <h3>Bản đồ</h3>
        <iframe 
          src="https://www.google.com/maps/embed?pb=..." 
          width="100%" 
          height="200" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy">
        </iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <!-- Giới thiệu -->
      <div class="footer-about">
        <h4>VỀ RẠP PHIM</h4>
        <p>Rạp Chiếu Phim CGV là hệ thống rạp hiện đại...</p>
        <p>Đặt vé online nhanh chóng – nhận vé ngay tại quầy.</p>
        <!-- Icon mạng xã hội -->
        <div class="social-icons">
          <a href="https://www.facebook.com/..."><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.youtube.com/..."><i class="fab fa-youtube"></i></a>
          <a href="https://www.tiktok.com/..."><i class="fab fa-tiktok"></i></a>
          <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Thông tin liên hệ -->
      <div class="footer-search">
        <h4>LIÊN HỆ</h4>
        <ul class="contact-info">
          <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Huệ, Quận 1, TP.HCM</li>
          <li><i class="fas fa-envelope"></i> hotro@rapchieuphim.vn</li>
          <li><i class="fas fa-phone"></i> 1900 1234</li>
        </ul>
      </div>

      <!-- Giờ mở cửa -->
      <div class="footer-hours">
        <h4>GIỜ MỞ CỬA</h4>
        <p>Thứ 2 - Thứ 6: <span>9:00 - 23:00</span></p>
        <p>Thứ 7 - CN: <span>8:00 - 24:00</span></p>
        <p>Lễ Tết: <span>8:00 - 24:00</span></p>
      </div>
    </div>
    <!-- Bản quyền -->
    <div class="footer-bottom">© 2025 Rạp Chiếu Phim CGV. All rights reserved.</div>
  </footer>

  <!-- File JavaScript xử lý form liên hệ -->
  <script src="../Javascript/lienhe.js"></script>
</body>
</html>
