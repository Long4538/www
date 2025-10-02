
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Menu Top CGV</title>
  <!-- <link rel="stylesheet" href="../Css/menu.css"> -->
  <link rel="stylesheet" href="../Css/style.css">
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
      <li><a href="../Page/dangnhap.php" class="active">Đăng nhập</a></li>
      <li><a href="../Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>
    <!-- Header -->

<?php
?>
<div class="auth-container">
	<h2 class="auth-title">Đăng nhập</h2>
	<?php if (!empty($message)): ?>
		<div class="error-message"><?php echo htmlspecialchars($message); ?></div>
	<?php endif; ?>
	<form method="post" action="auth/login" class="auth-form">
		<div class="auth-field">
			<label class="auth-label">Email</label>
			<input type="email" name="email" required class="auth-input" />
		</div>
		<div class="auth-field">
			<label class="auth-label">Mật khẩu</label>
			<input type="password" name="password" required class="auth-input" />
		</div>
		<button type="submit" class="auth-button">Đăng nhập</button>
	</form>
	<div class="auth-link">
		Chưa có tài khoản? <a href="../Page/dangky.php">Đăng ký</a>
	</div>
</div>


  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div>
        <h4>Về chúng tôi</h4>
        <p>Câu chuyện của chúng tôi<br>Phát triển bền vững<br>Tuyển dụng</p>
      </div>
      <div>
        <h4>Chăm sóc khách hàng</h4>
        <p>Liên hệ<br>Vận chuyển & trả lại<br>Câu hỏi thường gặp</p>
      </div>
      <div>
        <h4>Theo dõi chúng tôi</h4>
        <p>Facebook | Instagram | YouTube</p>
      </div>
    </div>
  </footer>

    <script src="../Javascript/lienhe.js"></script>

</body>
</html>
