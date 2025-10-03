
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Menu Top CGV</title>
  <!-- <link rel="stylesheet" href="../Css/menu.css"> -->
  <link rel="stylesheet" href="../Css/style.css">
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

    <!-- Menu items -->
    <ul>
      <li><a href="../Index.php">Trang chủ</a></li>
      <li><a href="../Page/phim.php">Phim</a></li>
      <li><a href="../Page/lienhe.php">Liên hệ</a></li>
      <li><a href="../Page/dangnhap.php" >Đăng nhập</a></li>
      <li><a href="../Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>
    <!-- Header -->

<?php
?>
<div class="auth-container">
	<h2 class="auth-title">Đăng ký</h2>
	<?php if (!empty($message)): ?>
		<div class="error-message"><?php echo htmlspecialchars($message); ?></div>
	<?php endif; ?>
	<form method="post" action="auth/register" class="auth-form">
		<div class="auth-field">
			<label class="auth-label">Họ tên</label>
			<input type="text" name="hoten" required class="auth-input" />
		</div>
		<div class="auth-field">
			<label class="auth-label">Email</label>
			<input type="email" name="email" required class="auth-input" />
		</div>
		<div class="auth-field">
			<label class="auth-label">Số điện thoại</label>
			<input type="text" name="phone" class="auth-input" />
		</div>
		<div class="auth-field">
			<label class="auth-label">Mật khẩu</label>
			<input type="password" name="password" required class="auth-input" />
		</div>
		<button type="submit" class="auth-button">Tạo tài khoản</button>
	</form>
	<div class="auth-link">
		Đã có tài khoản? <a href="../Page/dangnhap.php">Đăng nhập</a>
	</div>
</div>


  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <h4>VỀ RẠP PHIM</h4>
        <p>Rạp Chiếu Phim CGV là hệ thống rạp hiện đại với màn hình rộng, âm thanh vòm sống động, mang đến trải nghiệm điện ảnh tuyệt vời.</p>
        <p>Đặt vé online nhanh chóng – nhận vé ngay tại quầy chỉ với vài thao tác.</p>
        <div class="social-icons">
          <a href="https://www.facebook.com/nguyen.binhphuong.315?locale=vi_VN"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.youtube.com/@nguyenbinhphuong260"><i class="fab fa-youtube"></i></a>
          <a href="https://www.tiktok.com/@n_b_phuong7?lang=vi-VN"><i class="fab fa-tiktok"></i></a>
          <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <div class="footer-search">
        <h4>LIÊN HỆ</h4>
        <ul class="contact-info">
          <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Huệ, Quận 1, TP.HCM</li>
          <li><i class="fas fa-envelope"></i> hotro@rapchieuphim.vn</li>
          <li><i class="fas fa-phone"></i> 1900 1234</li>
        </ul>
      </div>

      <div class="footer-hours">
        <h4>GIỜ MỞ CỬA</h4>
        <p>Thứ 2 - Thứ 6: <span>9:00 - 23:00</span></p>
        <p>Thứ 7 - CN: <span>8:00 - 24:00</span></p>
        <p>Lễ Tết: <span>8:00 - 24:00</span></p>
      </div>
    </div>
    <div class="footer-bottom">© 2025 Rạp Chiếu Phim CGV. All rights reserved.</div>
  </footer>

    <script src="../Javascript/lienhe.js"></script>

</body>
</html>
