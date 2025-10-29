<?php
session_start();
require_once '../admincp/config.php'; // đảm bảo $pdo

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if (!$full_name || !$email || !$password || !$confirm) {
        $message = "Vui lòng nhập đầy đủ.";
    } elseif ($password !== $confirm) {
        $message = "Mật khẩu nhập lại không khớp.";
    } else {
        // kiểm tra email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = "Email đã tồn tại.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("
                INSERT INTO users (role_id, full_name, email, password_hash, is_verified, is_active, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $success = $insert->execute([2, $full_name, $email, $password_hash, 0, 1]);
            $message = $success ? "Đăng ký thành công" : "Lỗi lưu dữ liệu";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng ký - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">

  <style>
    body, html { height: 100%; }
    .video-background {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      z-index: -1;
      filter: brightness(60%);
    }
    .auth-container {
      min-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .auth-box {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .btn-brand { background-color: var(--bs-danger); color: #fff; border: none; }
    .btn-brand:hover { background-color: #c82333; }
  </style>
</head>
<body>

<!-- 🎬 VIDEO NỀN -->
<video autoplay muted loop playsinline class="video-background">
  <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
</video>

<!-- ========== TOP BAR ========== -->
<div class="bg-brand text-light py-2">
  <div class="container d-flex justify-content-between align-items-center small">
    <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
    <div class="d-flex gap-3">
      <a href="login.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
      <a href="register.php" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng ký</a>
      <a href="#" class="text-light text-decoration-none"><i class="bi bi-cart"></i> Giỏ hàng</a>
    </div>
  </div>
</div>

<!-- ========== HEADER ========== -->
<header class="py-3 bg-light border-bottom">
  <div class="container d-flex flex-wrap justify-content-between align-items-center">
    <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
      <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
    </a>
    <form class="d-flex flex-grow-1 mx-3" role="search">
      <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
      <button class="btn btn-brand" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <div class="text-end">
      <p class="mb-0 fw-bold text-secondary"><i class="bi bi-telephone"></i> Hotline: <span class="text-danger">0989 123 456</span></p>
      <small class="text-muted">Hỗ trợ 24/7</small>
    </div>
  </div>
</header>

<!-- ========== FORM ĐĂNG KÝ ========== -->
<div class="auth-container">
  <div class="auth-box">
    <h3 class="text-center fw-bold mb-4 text-brand">Đăng ký tài khoản</h3>

<?php if (!empty($message)): ?>
  <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Họ và tên</label>
        <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên đầy đủ" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
      </div>
      <div class="mb-4">
        <label class="form-label">Nhập lại mật khẩu</label>
        <input type="password" name="confirm" class="form-control" placeholder="Xác nhận mật khẩu" required>
      </div>
      <button type="submit" class="btn btn-brand w-100 mb-3">Đăng ký</button>
      <p class="text-center mb-0">Đã có tài khoản?
        <a href="../Pages/dangnhap.php" class="text-danger text-decoration-none">Đăng nhập ngay</a>
      </p>
    </form>
  </div>
</div>

<!-- ========== FOOTER ========== -->
<footer class="pt-5 pb-3 text-light bg-dark bg-opacity-75">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Về chúng tôi</h5>
        <p>Shop Nước Hoa DA cung cấp các dòng nước hoa chính hãng, giúp bạn tự tin và tỏa sáng mỗi ngày.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Chính sách</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light">Chính sách đổi trả</a></li>
          <li><a href="#" class="text-light">Bảo mật thông tin</a></li>
          <li><a href="#" class="text-light">Giao hàng toàn quốc</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Liên hệ</h5>
        <p><i class="bi bi-geo-alt"></i> 123 Nguyễn Trãi, TP.HCM</p>
        <p><i class="bi bi-envelope"></i> contact@nuochoada.vn</p>
        <p><i class="bi bi-telephone"></i> 0989 123 456</p>
      </div>
    </div>
    <div class="border-top pt-3 text-center">
      <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
    </div>
  </div>
</footer>

</body>
</html>
