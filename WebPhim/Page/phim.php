<?php
// ✅ Các thể loại phim (dùng cho sidebar menu lọc phim)
$theloai = [
    "Hành động",
    "Kinh dị",
    "Tình cảm",
    "Hài hước",
    "Hoạt hình",
    "Viễn tưởng",
    "Chính kịch",
    "Tâm lý",
];

// ✅ Danh sách phim (mỗi phim có: tên, ảnh, mô tả, thể loại)
$phim = [
    1 => [
        "ten" => "Bộ Tứ Báo Thủ",
        "anh" => "../Images/phim/phim1.jpg",
        "mota" => "Bộ tứ báo thủ bao gồm Chét-Xi-Cà, Dì Bốn, Cậu Mười Một, Con Kiều chính thức xuất hiện cùng với phi vụ báo thế kỉ...",
        "theloai" => "Hài hước"
    ],
    2 => [
        "ten" => "Thunderbolts",
        "anh" => "../Images/phim/phim2.jpg",
        "mota" => "Một nhóm phản anh hùng gồm Yelena Belova, Bucky Barnes, Red Guardian, US Agent và Taskmaster thực hiện nhiệm vụ cho chính phủ Mỹ.",
        "theloai" => "Hành động"
    ],
    3 => [
        "ten" => "When Life Gives You Tangerines",
        "anh" => "../Images/phim/phim3.jpg",
        "mota" => "Một bộ phim tình cảm nhẹ nhàng Hàn Quốc.",
        "theloai" => "Tình cảm"
    ],
    4 => [
        "ten" => "Nụ Hôn Bạc Tỷ",
        "anh" => "../Images/phim/phim4.jpg",
        "mota" => "Hài hước, tình cảm, hấp dẫn.",
        "theloai" => "Hài hước"
    ],
    5 => [
        "ten" => "The Trauma Code: Heroes on Call",
        "anh" => "../Images/phim/phim5.jpg",
        "mota" => "Câu chuyện về những bác sĩ cứu người nơi tuyến đầu.",
        "theloai" => "Chính kịch"
    ],
    6 => [
        "ten" => "Mưa Đỏ",
        "anh" => "../Images/phim/phim6.jpg",
        "mota" => "Một thảm kịch kinh hoàng giữa mưa máu.",
        "theloai" => "Tâm lý"
    ],
    7 => [
        "ten" => "The Conjuring: Nghi Lễ Cuối Cùng",
        "anh" => "../Images/phim/phim7.jpg",
        "mota" => "Phần cuối cùng của loạt phim kinh dị đình đám.",
        "theloai" => "Kinh dị"
    ],
    8 => [
        "ten" => "Khế Ước Bán Dâu",
        "anh" => "../Images/phim/phim8.jpg",
        "mota" => "Một khế ước định mệnh đầy bi thương.",
        "theloai" => "Tình cảm"
    ],
    9 => [
        "ten" => "Làm Giàu Với Ma 2: Cuộc Chiến Hột Xoàn",
        "anh" => "../Images/phim/phim9.jpg",
        "mota" => "Phần tiếp theo hài hước và kịch tính hơn.",
        "theloai" => "Hài hước"
    ],
    10 => [
        "ten" => "Thanh Gươm Diệt Quỷ: Vô Hạn Thành",
        "anh" => "../Images/phim/phim10.jpg",
        "mota" => "Trận chiến khốc liệt nhất trong Kimetsu no Yaiba.",
        "theloai" => "Hoạt hình"
    ],
    11 => [
        "ten" => "Venom 3 - Kèo Cuối",
        "anh" => "../Images/phim/p11.png",
        "mota" => "Phần phim cuối cùng và hoành tráng nhất về cặp đôi Venom và Eddie Brock.",
        "theloai" => "Hành động"
    ],
    12 => [
        "ten" => "Ngày Xưa Có Một Chuyện Tình",
        "anh" => "../Images/phim/p12.png",
        "mota" => "Câu chuyện tình bạn, tình yêu giữa hai chàng trai và một cô gái từ nhỏ đến trưởng thành.",
        "theloai" => "Tình cảm"
    ],
    13 => [
        "ten" => "Tiên Tri Tử Thần",
        "anh" => "../Images/phim/p13.png",
        "mota" => "Lời tiên tri bí ẩn mở ra hàng loạt vụ án rùng rợn khó lường.",
        "theloai" => "Kinh dị"
    ],
    14 => [
        "ten" => "Transformers One",
        "anh" => "../Images/phim/p14.png",
        "mota" => "Khởi nguồn cuộc chiến giữa Autobots và Decepticons.",
        "theloai" => "Hành động"
    ],
    15 => [
        "ten" => "Khóa chặt cửa nào Suzume",
        "anh" => "../Images/phim/p15.png",
        "mota" => "Cô gái trẻ cùng chàng trai bí ẩn bước vào hành trình đóng lại những cánh cửa thảm họa.",
        "theloai" => "Viễn tưởng"
    ],
];

// ✅ Lọc theo thể loại phim (nếu có chọn từ query string ?theloai=...)
$chonTheLoai = $_GET['theloai'] ?? null;
if ($chonTheLoai) {
    $phim = array_filter($phim, function($p) use ($chonTheLoai) {
        return $p['theloai'] === $chonTheLoai;
    });
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Phim - CGV</title>
  <!-- CSS chính -->
  <link rel="stylesheet" href="../Css/style.css">
  <link rel="stylesheet" href="../Css/phim.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- ✅ Thanh menu ngang -->
  <nav class="topnav">
    <div class="logo">
      <a href="../index.php"><img src="../Images/logo.png" alt="Logo CGV"></a>
    </div>
    <ul>
      <li><a href="../index.php">Trang chủ</a></li>
      <li><a href="../Page/phim.php" class="active">Phim</a></li>
      <li><a href="../Page/lienhe.php">Liên hệ</a></li>
      <li><a href="../Page/dangnhap.php">Đăng nhập</a></li>
      <li><a href="../Page/datve.php">Đặt vé</a></li>
    </ul>
  </nav>

  <div class="container">
    <!-- ✅ Menu dọc: danh sách thể loại phim -->
    <div class="sidebar">
      <h3>Thể loại phim</h3>
      <ul>
        <!-- Link xem tất cả -->
        <li><a href="phim.php" class="<?php echo !$chonTheLoai ? 'active' : ''; ?>">Tất cả</a></li>
        <!-- Lặp qua các thể loại để tạo menu -->
        <?php foreach ($theloai as $tl): ?>
          <li>
            <a href="phim.php?theloai=<?php echo urlencode($tl); ?>" 
               class="<?php echo ($chonTheLoai === $tl) ? 'active' : ''; ?>">
               <?php echo $tl; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- ✅ Nội dung danh sách phim -->
    <div class="content">
      <h2>
        <?php echo $chonTheLoai ? "Phim thể loại: $chonTheLoai" : "Danh sách phim"; ?>
      </h2>
      <div class="phim-container">
        <?php if (empty($phim)): ?>
          <!-- Nếu không có phim nào -->
          <p>Không có phim nào trong thể loại này.</p>
        <?php else: ?>
          <!-- Lặp qua danh sách phim -->
          <?php foreach ($phim as $id => $p): ?>
            <div class="phim-item">
              <a href="chitietphim.php?id=<?php echo $id; ?>">
                <img src="<?php echo $p['anh']; ?>" alt="<?php echo $p['ten']; ?>">
                <h3><?php echo $p['ten']; ?></h3>
              </a>
              <p><?php echo $p['mota']; ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ✅ Footer -->
  <footer>
    <div class="footer-container">
      <!-- Thông tin về rạp -->
      <div class="footer-about">
        <h4>VỀ RẠP PHIM</h4>
        <p>Rạp Chiếu Phim CGV là hệ thống rạp hiện đại với màn hình rộng, âm thanh vòm sống động, mang đến trải nghiệm điện ảnh tuyệt vời.</p>
        <p>Đặt vé online nhanh chóng – nhận vé ngay tại quầy chỉ với vài thao tác.</p>
        <!-- Mạng xã hội -->
        <div class="social-icons">
          <a href="https://www.facebook.com/nguyen.binhphuong.315?locale=vi_VN"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.youtube.com/@nguyenbinhphuong260"><i class="fab fa-youtube"></i></a>
          <a href="https://www.tiktok.com/@n_b_phuong7?lang=vi-VN"><i class="fab fa-tiktok"></i></a>
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
    <div class="footer-bottom">© 2025 Rạp Chiếu Phim CGV. All rights reserved.</div>
  </footer>
</body>
</html>
