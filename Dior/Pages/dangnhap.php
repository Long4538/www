<?php
session_start();
require_once '../admincp/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email && $password) {
        // Lấy thông tin user theo email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Kiểm tra mật khẩu đúng không
            if (password_verify($password, $user['password_hash'])) {

                // ✅ Đổi confirm → is_verified (đúng với cấu trúc trong SQL bạn gửi)
                if ($user['is_verified'] == 2 && $user['role_id'] != 1) {
                    $message = "Tài khoản chưa được xác minh email.";
                } else {
                    // ✅ Giữ lại giỏ hàng cũ (nếu có)
                    $saved_cart = $_SESSION['cart'] ?? [];

                    // ✅ Làm mới session ID để bảo mật nhưng vẫn giữ giỏ hàng
                    session_regenerate_id(true);

                    // ✅ Lưu thông tin đăng nhập vào session
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['role_id']   = $user['role_id'];

                    // ✅ Khôi phục giỏ hàng cũ
                    if (!empty($saved_cart)) {
                        $_SESSION['cart'] = $saved_cart;
                    }

                    // ✅ Nếu là admin → chuyển đến trang quản trị
                    if ($user['role_id'] == 1) {
                        header("Location: ../admincp/admin.php");
                        exit;
                    }

                    // ✅ Kiểm tra nếu có redirect (ví dụ khi bấm "Đăng nhập để thanh toán")
                    $redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? '../Index.php';
                    header("Location: $redirect");
                    exit;
                }

            } else {
                $message = "Mật khẩu không đúng!";
            }
        } else {
            $message = "Email không tồn tại!";
        }
    } else {
        $message = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng nhập - Shop Nước Hoa DA</title>
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
      <a href="dangky.php" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng ký</a>
      <a href="giohang.php" class="text-light text-decoration-none"><i class="bi bi-cart"></i> Giỏ hàng</a>
    </div>
  </div>
</div>

<!-- ========== HEADER ========== -->
<header class="py-3 bg-light border-bottom">
  <div class="container d-flex flex-wrap justify-content-between align-items-center">
    <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
      <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
    </a>
    <form class="d-flex flex-grow-1 mx-3" role="search" action="../Pages/timkiem.php" method="get">
      <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." name="q" required>
      <button class="btn btn-brand" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <div class="text-end">
      <p class="mb-0 fw-bold text-secondary"><i class="bi bi-telephone"></i> Hotline: <span class="text-danger">0989 123 456</span></p>
      <small class="text-muted">Hỗ trợ 24/7</small>
    </div>
  </div>
</header>

<!-- ========== FORM ĐĂNG NHẬP ========== -->
<div class="auth-container">
  <div class="auth-box">
    <h3 class="text-center fw-bold mb-4 text-brand">Đăng nhập</h3>

    <?php if ($message): ?>
      <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
      </div>

      <?php if (isset($_GET['redirect'])): ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']) ?>">
      <?php endif; ?>

      <div class="d-flex justify-content-between mb-3">
        <div>
          <input type="checkbox" id="remember">
          <label for="remember">Ghi nhớ đăng nhập</label>
        </div>
        <a href="#" class="text-danger">Quên mật khẩu?</a>
      </div>

      <button type="submit" class="btn btn-brand w-100 mb-3">Đăng nhập</button>
      <p class="text-center mb-0">Chưa có tài khoản?
        <a href="../Pages/dangky.php" class="text-danger text-decoration-none">Đăng ký ngay</a>
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
