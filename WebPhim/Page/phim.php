<?php
// Các thể loại phim
$theloai = [
    "Hành động",
    "Kinh dị",
    "Tình cảm",
    "Hài hước",
    "Hoạt hình",
    "Viễn tưởng"
];

// Danh sách phim (có thêm thể loại)
$phim = [
    1 => ["ten" => "Bộ Tứ Báo Thủ", "anh" => "../Images/phim/phim1.jpg", "mota" => "Phim hành động siêu anh hùng của Marvel.", "theloai" => "Hành động"],
    2 => ["ten" => "Thunderbolts", "anh" => "../Images/phim/phim2.jpg", "mota" => "Nhóm phản anh hùng tập hợp để cứu thế giới.", "theloai" => "Hành động"],
    3 => ["ten" => "When Life Gives You Tangerines", "anh" => "../Images/phim/phim3.jpg", "mota" => "Một bộ phim tình cảm nhẹ nhàng Hàn Quốc.", "theloai" => "Tình cảm"],
    4 => ["ten" => "Nụ Hôn Bạc Tỷ", "anh" => "../Images/phim/phim4.jpg", "mota" => "Hài hước, tình cảm, hấp dẫn.", "theloai" => "Hài hước"],
    5 => ["ten" => "The Trauma Code: Heroes on Call", "anh" => "../Images/phim/phim5.jpg", "mota" => "Câu chuyện về những bác sĩ cứu người nơi tuyến đầu.", "theloai" => "Tình cảm"],
    6 => ["ten" => "The Conjuring: Nghi Lễ Cuối Cùng", "anh" => "../Images/phim/phim7.jpg", "mota" => "Phần cuối cùng của loạt phim kinh dị đình đám.", "theloai" => "Kinh dị"],
];

// Lọc theo thể loại (nếu có chọn)
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
  <link rel="stylesheet" href="../Css/style.css">
  <style>
    .container { display: flex; margin: 20px; margin-top: 80px; }
    .sidebar { width: 220px; background: #333; color: #fff; padding: 20px; border-radius: 10px; margin-right: 20px; }
    .sidebar h3 { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #555; padding-bottom: 10px; }
    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 12px 0; }
    .sidebar ul li a { color: #fff; text-decoration: none; display: block; padding: 8px; border-radius: 5px; transition: 0.3s; }
    .sidebar ul li a:hover, .sidebar ul li a.active { background: #e50914; }
    .content { flex: 1; }
    .phim-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .phim-item { background: #f8f8f8; border-radius: 10px; overflow: hidden; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
    .phim-item img { width: 100%; height: 280px; object-fit: cover; }
    .phim-item h3 { margin: 10px 0; }
    .phim-item p { font-size: 14px; padding: 0 10px 10px; color: #666; }
  </style>
</head>
<body>
  <!-- Menu ngang -->
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
    <!-- Menu dọc -->
    <div class="sidebar">
      <h3>Thể loại phim</h3>
      <ul>
        <li><a href="phim.php" class="<?php echo !$chonTheLoai ? 'active' : ''; ?>">Tất cả</a></li>
        <?php foreach ($theloai as $tl): ?>
          <li><a href="phim.php?theloai=<?php echo urlencode($tl); ?>" class="<?php echo ($chonTheLoai === $tl) ? 'active' : ''; ?>"><?php echo $tl; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Danh sách phim -->
    <div class="content">
      <h2><?php echo $chonTheLoai ? "Phim thể loại: $chonTheLoai" : "Danh sách phim"; ?></h2>
      <div class="phim-container">
        <?php if (empty($phim)): ?>
          <p>Không có phim nào trong thể loại này.</p>
        <?php else: ?>
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
</body>
</html>
