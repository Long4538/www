<?php
session_start();

// ✅ Kiểm tra đăng nhập
// if (!isset($_SESSION['user'])) {
//     $_SESSION['error'] = "Vui lòng đăng nhập để đặt vé!";
//     header("Location: dangnhap.php");
//     exit;
// }


$phim = [
    1 => "Bộ Tứ Báo Thủ",
    2 => "Thunderbolts",
    3 => "When Life Gives You Tangerines",
    4 => "Nụ Hôn Bạc Tỷ",
    5 => "The Trauma Code: Heroes on Call",
    6 => "Mưa Đỏ",
    7 => "The Conjuring: Nghi Lễ Cuối Cùng",
    8 => "Khế Ước Bán Dâu",
    9 => "Làm Giàu Với Ma 2: Cuộc Chiến Hột Xoàn",
    10 => "Thanh Gươm Diệt Quỷ: Vô Hạn Thành",
    11 => "Venom 3 - Kèo Cuối",
    12 => "Ngày Xưa Có Một Chuyện Tình",
    13 => "Tiên Tri Tử Thần",
    14 => "Transformers One",
    15 => "Khóa Chặt Cửa Nào Suzume"
];



$gioChieu = ["09:00", "14:00", "19:00"];
$rap = ["CGV Vincom Quận 1", "CGV Aeon Tân Phú", "CGV Landmark 81"];

// Nếu submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['datve'] = $_POST;
    header("Location: thanhtoan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt vé xem phim</title>
  <link rel="stylesheet" href="../Css/datve.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      <li><a href="../Page/dangnhap.php" >Đăng nhập</a></li>
      <li><a href="../Page/datve.php" class="active">Đặt vé</a></li>
    </ul>
  </nav>

<div class="container">
  <h2>🎬 Đặt vé xem phim</h2>

  <form method="POST">
    <!-- Thông tin khách hàng -->
    <label>Họ và tên:</label>
    <input type="text" class="form-control" name="hoten" required>

    <label>Email:</label>
    <input type="email" class="form-control" name="email" required>

    <label>Số điện thoại:</label>
    <input type="text" class="form-control" name="sdt" required>

    <!-- Chọn phim -->
    <label>Chọn phim:</label>
    <select name="phim" required>
      <option value="">--Chọn phim--</option>
      <?php foreach ($phim as $id => $ten): ?>
        <option value="<?= $ten ?>"><?= $ten ?></option>
      <?php endforeach; ?>
    </select>

    <!-- Ngày chiếu -->
    <label>Ngày chiếu:</label>
    <input type="date" class="form-control" name="ngay" required>

    <!-- Giờ chiếu -->
    <label>Giờ chiếu:</label>
    <select name="gio" required>
      <?php foreach ($gioChieu as $g): ?>
        <option value="<?= $g ?>"><?= $g ?></option>
      <?php endforeach; ?>
    </select>

    <!-- Rạp -->
    <label>Địa chỉ rạp:</label>
    <select name="rap" required>
      <?php foreach ($rap as $r): ?>
        <option value="<?= $r ?>"><?= $r ?></option>
      <?php endforeach; ?>
    </select>

    <!-- Số lượng ghế -->
    <label>Số lượng ghế:</label>
    <select name="soluong" id="soluong" onchange="taoGhe()" required>
      <option value="">--Chọn--</option>
      <option value="1">1 ghế</option>
      <option value="2">2 ghế</option>
      <option value="3">3 ghế</option>
      <option value="4">4 ghế</option>
      <option value="5">5 ghế</option>
    </select>

    <div class="manhinh">MÀN HÌNH</div>
    <!-- Chọn ghế -->
    <div id="sodoRap"></div>

    <!-- Hiện tổng tiền -->
    <p><strong>Tổng tiền: </strong><span id="tongtien">0</span> VND</p>

    <button type="submit">Đặt vé</button>
  </form>
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

<script src="../JavaScript/datve.js"></script>
</body>
</html>
