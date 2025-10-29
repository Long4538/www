<?php
session_start();
require_once '../admincp/config.php';

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
  header('Location: dangnhap.php');
  exit;
}

// ✅ Lấy thông tin người dùng
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT full_name, email, phone, avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Lấy thông báo chưa đọc
$notifStmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
$notifStmt->execute([$user_id]);
$notifications = $notifStmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Đánh dấu thông báo là đã đọc (tuỳ chọn, nếu muốn chỉ hiển thị 1 lần)
$pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0")->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tài khoản của tôi | Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    .overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,192,203,0.3)); z-index:1; }
    .account-card { position: relative; z-index:2; background: rgba(255,255,255,0.9); border-radius:20px; box-shadow:0 8px 25px rgba(0,0,0,0.1); backdrop-filter: blur(8px); padding:40px; }
    .avatar { width:130px; height:130px; border-radius:50%; border:3px solid #f7b6c5; object-fit:cover; box-shadow:0 4px 15px rgba(255,182,193,0.5); }
    .btn-brand { background-color:#e88ea2; color:white; border:none; transition:0.3s; }
    .btn-brand:hover { background-color:#d6738d; color:white; }
    .account-section { min-height:100vh; display:flex; align-items:center; justify-content:center; position:relative; z-index:2; }
  </style>
</head>

<body>
  <!-- Video nền -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <!-- Lớp phủ mềm màu hồng -->
  <div class="overlay"></div>

  <div class="site-content">

    <!-- TOP BAR -->
    <div class="bg-brand text-light py-2" style="z-index:3; position:relative;">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
        <div class="d-flex gap-3">
          <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
            <a href="../admincp/admin.php" class="text-warning fw-bold">Quản trị</a>
          <?php endif; ?>
          <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
          <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        </div>
      </div>
    </div>

    <!-- Thông báo -->
    <div class="container mt-4">
      <?php if(!empty($notifications)): ?>
        <?php foreach($notifications as $notif): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($notif['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Thông tin tài khoản -->
    <section class="account-section">
      <div class="container">
        <div class="account-card mx-auto col-md-8 col-lg-6 text-center">
          <img src="<?= $user['avatar'] ? '../uploads/' . htmlspecialchars($user['avatar']) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>" 
               alt="Avatar người dùng" class="avatar mb-3">
          <h2 class="text-primary fw-bold mb-3"><i class="bi bi-person-circle"></i> Thông tin tài khoản</h2>

          <ul class="list-group list-group-flush text-start mb-4">
            <li class="list-group-item bg-transparent"><strong>Họ và tên:</strong> <?= htmlspecialchars($user['full_name']) ?></li>
            <li class="list-group-item bg-transparent"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
            <li class="list-group-item bg-transparent"><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></li>
          </ul>

          <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
            <a href="user_orders.php" class="btn btn-brand"><i class="bi bi-box"></i> Xem đơn hàng</a>
            <a href="user_notifications.php" class="btn btn-outline-warning"><i class="bi bi-bell"></i> Thông báo</a>
            <a href="dangxuat.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
          </div>

          <div class="mt-3">
            <a href="../index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại trang chủ</a>
          </div>

        </div>
      </div>
    </section>

    <footer class="pt-5 pb-3 text-white" style="background: rgba(0,0,0,0.4); z-index:3; position:relative;">
      <div class="container text-center">
        <p class="mb-1">© 2025 Shop Nước Hoa DA - Tự tin & Tỏa sáng mỗi ngày 🌸</p>
        <small>Hotline: 0989 123 456 | Email: contact@nuochoada.vn</small>
      </div>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
