<?php
// Danh sách phim
$phim = [
    1 => ["ten" => "Bộ Tứ Báo Thủ", "anh" => "../Images/phim/phim1.jpg"],
    2 => ["ten" => "Thunderbolts", "anh" => "../Images/phim/phim2.jpg"],
    3 => ["ten" => "When Life Gives You Tangerines", "anh" => "../Images/phim/phim3.jpg"],
    4 => ["ten" => "Nụ Hôn Bạc Tỷ", "anh" => "../Images/phim/phim4.jpg"],
    5 => ["ten" => "The Trauma Code: Heroes on Call", "anh" => "../Images/phim/phim5.jpg"],
    6 => ["ten" => "The Conjuring: Nghi Lễ Cuối Cùng", "anh" => "../Images/phim/phim7.jpg"],
];

$id = $_GET['id'] ?? null;

if (!$id || !isset($phim[$id])) {
    die("<h2>Phim không tồn tại!</h2><a href='phim.php'>Quay lại</a>");
}

$movie = $phim[$id];

// Xử lý khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suat = $_POST['suat'] ?? '';
    $ghe = $_POST['ghe'] ?? [];
    if (!$suat || empty($ghe)) {
        echo "<p style='color:red; text-align:center;'>❌ Bạn chưa chọn suất chiếu hoặc ghế!</p>";
    } else {
        $dsGhe = implode(", ", $ghe);
        echo "<div style='padding:20px; text-align:center;'>
                <h2>✅ Đặt vé thành công!</h2>
                <p>Bạn đã đặt <strong>".count($ghe)." vé</strong> cho phim <strong>{$movie['ten']}</strong>.</p>
                <p>Suất chiếu: <strong>{$suat}</strong></p>
                <p>Ghế: <strong>{$dsGhe}</strong></p>
                <a href='phim.php' style='display:inline-block;margin-top:20px;padding:10px 15px;background:#e50914;color:#fff;text-decoration:none;border-radius:5px;'>Quay lại danh sách phim</a>
              </div>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt vé - <?php echo $movie['ten']; ?></title>
  <link rel="stylesheet" href="../Css/style.css">
  <style>
    .datve-container { max-width: 900px; margin: 40px auto; }
    .movie-info { display: flex; gap: 30px; margin-bottom: 30px; }
    .movie-info img { width: 250px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
    .form-datve { flex: 1; }
    .form-datve h2 { margin-bottom: 20px; color: #e50914; }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: bold; }
    .form-group select { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }

    /* Ghế ngồi */
    .seat-map { margin: 20px 0; text-align: center; }
    .row { display: flex; justify-content: center; margin-bottom: 10px; }
    .seat {
      width: 40px; height: 40px; margin: 5px; line-height: 40px;
      text-align: center; border-radius: 6px;
      background: #eee; cursor: pointer; font-size: 14px;
      border: 1px solid #ccc; user-select: none;
    }
    .seat.selected { background: #e50914; color: #fff; }
    .seat.occupied { background: #444; color: #fff; cursor: not-allowed; }

    .btn-submit {
      background: #e50914; color: #fff; border: none;
      padding: 12px 20px; font-size: 16px; font-weight: bold;
      border-radius: 6px; cursor: pointer; transition: 0.3s;
      display: block; margin: 20px auto;
    }
    .btn-submit:hover { background: #b20710; }
  </style>
</head>
<body>
  <!-- Menu -->
  <nav class="topnav">
    <div class="logo">
      <a href="../index.php"><img src="../Images/logo.png" alt="Logo CGV"></a>
    </div>
    <ul>
      <li><a href="../index.php">Trang chủ</a></li>
      <li><a href="phim.php" class="active">Phim</a></li>
      <li><a href="lienhe.php">Liên hệ</a></li>
      <li><a href="dangnhap.php">Đăng nhập</a></li>
      <li><a href="dangky.php">Đăng ký</a></li>
    </ul>
  </nav>

  <div class="datve-container">
    <div class="movie-info">
      <img src="<?php echo $movie['anh']; ?>" alt="<?php echo $movie['ten']; ?>">
      <div class="form-datve">
        <h2>Đặt vé: <?php echo $movie['ten']; ?></h2>
        <form method="POST">
          <div class="form-group">
            <label for="suat">Chọn suất chiếu:</label>
            <select name="suat" id="suat" required>
              <option value="">-- Chọn suất --</option>
              <option value="09:00">09:00</option>
              <option value="13:30">13:30</option>
              <option value="16:00">16:00</option>
              <option value="19:30">19:30</option>
              <option value="22:00">22:00</option>
            </select>
          </div>

          <!-- Sơ đồ ghế -->
          <div class="seat-map">
            <h3>Chọn ghế</h3>
            <?php
            $rows = ['A','B','C','D','E'];
            $cols = 6;
            foreach ($rows as $r) {
                echo "<div class='row'>";
                for ($c=1; $c<=$cols; $c++) {
                    $seatId = $r.$c;
                    echo "<div class='seat' onclick='toggleSeat(this)'>
                            $seatId
                            <input type='checkbox' name='ghe[]' value='$seatId' style='display:none'>
                          </div>";
                }
                echo "</div>";
            }
            ?>
          </div>

          <button type="submit" class="btn-submit">🎟 Xác nhận đặt vé</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleSeat(el) {
      if (el.classList.contains("occupied")) return;
      const checkbox = el.querySelector("input");
      el.classList.toggle("selected");
      checkbox.checked = !checkbox.checked;
    }
  </script>
</body>
</html>
