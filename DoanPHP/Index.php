<?php
// Danh sách phim nổi bật
$phim = [
    1 => ["ten" => "Bộ Tứ Báo Thủ", "anh" => "Images/phim/phim1.jpg", "mota" => "Phim hành động siêu anh hùng của Marvel."],
    2 => ["ten" => "Thunderbolts", "anh" => "Images/phim/phim2.jpg", "mota" => "Nhóm phản anh hùng tập hợp để cứu thế giới."],
    3 => ["ten" => "When Life Gives You Tangerines", "anh" => "Images/phim/phim3.jpg", "mota" => "Một bộ phim tình cảm nhẹ nhàng Hàn Quốc."],
    4 => ["ten" => "Nụ Hôn Bạc Tỷ", "anh" => "Images/phim/phim4.jpg", "mota" => "Hài hước, tình cảm, hấp dẫn."],
    5 => ["ten" => "The Trauma Code: Heroes on Call", "anh" => "Images/phim/phim5.jpg", "mota" => "Câu chuyện về những bác sĩ cứu người nơi tuyến đầu."],
];

// Danh sách phim mới
$phimMoi = [
    6 => ["ten" => "Mưa Đỏ", "anh" => "Images/phim/phim6.jpg", "mota" => "Một thảm kịch kinh hoàng giữa mưa máu."],
    7 => ["ten" => "The Conjuring: Nghi Lễ Cuối Cùng", "anh" => "Images/phim/phim7.jpg", "mota" => "Phần cuối cùng của loạt phim kinh dị đình đám."],
    8 => ["ten" => "Khế Ước Bán Dâu", "anh" => "Images/phim/phim8.jpg", "mota" => "Một khế ước định mệnh đầy bi thương."],
    9 => ["ten" => "Làm Giàu Với Ma 2: Cuộc Chiến Hột Xoàn", "anh" => "Images/phim/phim9.jpg", "mota" => "Phần tiếp theo hài hước và kịch tính hơn."],
    10 => ["ten" => "Thanh Gươm Diệt Quỷ: Vô Hạn Thành", "anh" => "Images/phim/phim10.jpg", "mota" => "Trận chiến khốc liệt nhất trong Kimetsu no Yaiba."],
];
?>
<?php
// Danh sách phim slideshow
$slideshow = [
    11 => [
        "ten" => "Venom 3 - Kèo Cuối",
        "anh" => "Images/banner/banner-1.png",
        "mota" => "Eddie Brock và Venom đối mặt thử thách sinh tử trong trận chiến cuối cùng."
    ],
    12 => [
        "ten" => "Ngày Xưa Có Một Chuyện Tình",
        "anh" => "Images/banner/banner-2.png",
        "mota" => "Câu chuyện tình tuổi học trò trong sáng, lãng mạn nhưng đầy day dứt."
    ],
    13 => [
        "ten" => "Tiên Tri Tử Thần",
        "anh" => "Images/banner/banner-3.png",
        "mota" => "Lời tiên tri bí ẩn mở ra hàng loạt vụ án rùng rợn khó lường."
    ],
    14 => [
        "ten" => "Transformers One",
        "anh" => "Images/banner/banner-4.png",
        "mota" => "Khởi nguồn cuộc chiến giữa Autobots và Decepticons."
    ],
    15 => [
        "ten" => "Khóa chặt cửa nào Suzume",
        "anh" => "Images/banner/banner-5.png",
        "mota" => "Cô gái trẻ cùng chàng trai bí ẩn bước vào hành trình đóng lại những cánh cửa thảm họa."
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Menu Top CGV</title>
  <link rel="stylesheet" href="Css/style.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Thanh menu top -->
  <nav class="topnav">
    <div class="logo">
      <a href="index.php">
        <img src="images/logo.png" alt="Logo CJ CGV">
      </a>
    </div>

    <ul>
      <li><a href="index.php" class="active">Trang chủ</a></li>
      <li><a href="Page/phim.php">Phim</a></li>
      <li><a href="Page/lienhe.php">Liên hệ</a></li>
      <li><a href="Page/dangnhap.php">Đăng nhập</a></li>
      <li><a href="Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>


<!-- Slideshow -->
<div class="slideshow-container">
  <?php foreach ($slideshow as $id => $p): ?>
    <div class="mySlides fade">
      <a href="Page/chitietphim.php?id=<?php echo $id; ?>">
        <img src="<?php echo $p['anh']; ?>" alt="<?php echo $p['ten']; ?>">
      </a>
    </div>
  <?php endforeach; ?>

  <!-- Nút điều hướng -->
  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>
</div>

<!-- Dots -->
<div class="dots" style="text-align:center">
  <?php foreach ($slideshow as $id => $p): ?>
    <span class="dot" onclick="currentSlide(<?php echo $id-10; ?>)"></span>
  <?php endforeach; ?>
</div>

  <!-- Phim nổi bật -->
  <div class="phimnoibat">
    <h2>PHIM NỔI BẬT</h2>
    <div class="phim-container">
      <?php foreach ($phim as $id => $p): ?>
        <div class="phim-item">
          <a href="Page/chitietphim.php?id=<?php echo $id; ?>">
            <img src="<?php echo $p['anh']; ?>" alt="<?php echo $p['ten']; ?>">
            <h3><?php echo $p['ten']; ?></h3>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Phim mới -->
  <div class="phimnoibat">
    <h2>PHIM MỚI</h2>
    <div class="phim-container">
      <?php foreach ($phimMoi as $id => $p): ?>
        <div class="phim-item">
          <a href="Page/chitietphim.php?id=<?php echo $id; ?>">
            <img src="<?php echo $p['anh']; ?>" alt="<?php echo $p['ten']; ?>">
            <h3><?php echo $p['ten']; ?></h3>
          </a>
        </div>
      <?php endforeach; ?>
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
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-tiktok"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
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

  <script src="Javascript/slideshow.js"></script>
</body>
</html>
