<?php
session_start();
require_once '../admincp/config.php';

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: dangnhap.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Lấy thông báo mới nhất của người dùng
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thông báo đơn hàng | Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    /* 🌸 Video nền & overlay */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,182,193,0.3));
      z-index: 1;
    }

    /* 🌷 Nội dung chính */
    .notifications-section {
      position: relative;
      z-index: 2;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .notifications-card {
      background: rgba(255, 255, 255, 0.93);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 100%;
      max-width: 700px;
    }

    /* 🎀 Nút cùng tone */
    .btn-brand {
      background-color: #e88ea2;
      color: white;
      border: none;
      transition: 0.3s;
    }
    .btn-brand:hover {
      background-color: #d6738d;
      color: white;
    }

    .list-group-item {
      background-color: rgba(255,255,255,0.9);
      border: none;
      border-bottom: 1px solid #f1f1f1;
      border-radius: 12px;
      margin-bottom: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      transition: 0.3s;
    }
    .list-group-item:hover {
      transform: translateY(-2px);
      background-color: #fff3f6;
    }

    .badge.bg-warning {
      background-color: #ffe082 !important;
      color: #795548 !important;
    }

    .footer {
      background: rgba(0, 0, 0, 0.4);
      color: white;
      padding: 20px 0;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <!-- 🌸 Video nền -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <!-- 🌸 Overlay hồng phấn -->
  <div class="overlay"></div>

  <!-- ====== TOP BAR ====== -->
  <div class="bg-brand text-light py-2" style="z-index:3; position:relative;">
    <div class="container d-flex justify-content-between align-items-center small">
      <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
      <div class="d-flex gap-3">
        <a href="../index.php" class="text-light text-decoration-none"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="taikhoan.php" class="text-light text-decoration-none"><i class="bi bi-person-circle"></i> Tài khoản</a>
        <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
      </div>
    </div>
  </div>

  <!-- ====== DANH SÁCH THÔNG BÁO ====== -->
  <section class="notifications-section">
    <div class="notifications-card">
      <h2 class="text-center text-primary mb-4">
        <i class="bi bi-bell"></i> Thông báo đơn hàng
      </h2>

      <?php if ($notifications): ?>
        <ul class="list-group">
          <?php foreach ($notifications as $note): ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <?= htmlspecialchars($note['message']) ?>
                <br><small class="text-muted"><?= $note['created_at'] ?></small>
              </div>
              <?php if (!$note['is_read']): ?>
                <span class="badge bg-warning text-dark">Mới</span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <i class="bi bi-info-circle"></i> Hiện bạn chưa có thông báo nào.
        </div>
      <?php endif; ?>

      <div class="text-center mt-4">
        <a href="taikhoan.php" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại tài khoản
        </a>
        <a href="../index.php" class="btn btn-brand ms-2">
          <i class="bi bi-house"></i> Về trang chủ
        </a>
      </div>
    </div>
  </section>

  <!-- ====== FOOTER ====== -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 Shop Nước Hoa DA - Tỏa sáng cùng hương thơm 🌸</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
