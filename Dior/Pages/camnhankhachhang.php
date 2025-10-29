<?php
session_start();
require '../admincp/config.php';

// Đếm số lượng sản phẩm trong giỏ hàng
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

// Kiểm tra user đã đăng nhập
$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? null;

// Lấy feedback hiện có
$feedbacks = $pdo->query("
    SELECT cf.customer_name, cf.feedback, cf.created_at
    FROM customer_feedback cf
    ORDER BY cf.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra đơn hàng đã hoàn tất để hiển thị form
$can_feedback = false;
if ($user_id) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM orders 
        WHERE user_id = :user_id AND status = 'completed'
    ");
    $stmt->execute(['user_id' => $user_id]);
    $can_feedback = $stmt->fetchColumn() > 0;
}

// Xử lý gửi feedback
$success_msg = $error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    if ($can_feedback) {
        $customer_name = $_POST['customer_name'] ?? $user_name;
        $feedback = $_POST['feedback'] ?? '';
        if (!empty(trim($feedback))) {
            $stmt = $pdo->prepare("
                INSERT INTO customer_feedback (customer_name, feedback) 
                VALUES (:customer_name, :feedback)
            ");
            $stmt->execute([
                'customer_name' => $customer_name,
                'feedback' => $feedback
            ]);
            $success_msg = "Cảm ơn bạn đã gửi ý kiến!";
            // Load lại feedback
            $feedbacks = $pdo->query("
                SELECT cf.customer_name, cf.feedback, cf.created_at
                FROM customer_feedback cf
                ORDER BY cf.created_at DESC
            ")->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error_msg = "Vui lòng nhập ý kiến trước khi gửi.";
        }
    } else {
        $error_msg = "Bạn chỉ có thể gửi ý kiến sau khi mua hàng thành công.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Cảm nhận khách hàng - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>
<div class="site-content">

<!-- ===== TOP BAR ===== -->
<div class="bg-brand text-light py-2">
  <div class="container d-flex justify-content-between align-items-center small">
    <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
    <div class="d-flex gap-3 align-items-center">
        <?php if ($user_name): ?>
            <span>Xin chào, <strong><?= htmlspecialchars($user_name) ?></strong>!</span>
            <a href="taikhoan.php" class="text-light text-decoration-none"><i class="bi bi-person-circle"></i> Tài khoản</a>
            <a href="dangxuat.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        <?php else: ?>
            <a href="dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
        <?php endif; ?>

      <a href="giohang.php" class="text-light text-decoration-none position-relative">
        <i class="bi bi-cart"></i> Giỏ hàng
        <?php if ($cart_count > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= $cart_count ?>
          </span>
        <?php endif; ?>
      </a>
    </div>
  </div>
</div>

<!-- ===== HEADER ===== -->
<header class="py-3 bg-light border-bottom">
  <div class="container d-flex flex-wrap justify-content-between align-items-center">
    <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
      <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
    </a>
    <form class="d-flex flex-grow-1 mx-3" role="search" action="timkiem.php" method="get">
      <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
      <button class="btn btn-brand" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <div class="text-end">
      <p class="mb-0 fw-bold text-secondary">
        <i class="bi bi-telephone"></i> Hotline: <span class="text-danger">0989 123 456</span>
      </p>
      <small class="text-muted">Hỗ trợ 24/7</small>
    </div>
  </div>
</header>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-brand" href="../index.php">Trang chủ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="gioithieu.php">Giới thiệu</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Nước hoa</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="nuochoanam.php">Nước hoa Nam</a></li>
            <li><a class="dropdown-item" href="nuochoanu.php">Nước hoa Nữ</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="khuyenmai.php">Khuyến mãi</a></li>
        <li class="nav-item"><a class="nav-link" href="phukien.php">Phụ kiện</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Hoạt động</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item active" href="camnhankhachhang.php">Cảm nhận khách hàng</a></li>
            <li><a class="dropdown-item" href="khachhang.php">Khách hàng của DA</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="vechungtoi.php">Về chúng tôi</a></li>
        <li class="nav-item"><a class="nav-link" href="lienhe.php">Liên hệ</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ===== CẢM NHẬN KHÁCH HÀNG ===== -->
<section class="py-5 text-center">
  <div class="container">
    <h2 class="fw-bold mb-4 text-brand">Cảm nhận khách hàng</h2>

    <?php if (!$user_id): ?>
        <div class="alert alert-warning">Vui lòng <a href="dangnhap.php">đăng nhập</a> để gửi ý kiến.</div>
    <?php elseif (!$can_feedback): ?>
        <div class="alert alert-info">Bạn chỉ có thể gửi ý kiến sau khi mua hàng thành công.</div>
    <?php else: ?>
        <?php if ($success_msg) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
        <?php if ($error_msg) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

        <form method="POST" class="mb-4">
          <div class="mb-3 text-start">
            <label class="form-label">Tên của bạn</label>
            <input type="text" class="form-control" name="customer_name" value="<?= htmlspecialchars($user_name) ?>" readonly>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label">Ý kiến</label>
            <textarea class="form-control" name="feedback" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-brand">Gửi ý kiến</button>
        </form>
    <?php endif; ?>

    <hr class="my-4">

    <div class="row g-4">
      <?php if ($feedbacks): ?>
          <?php foreach ($feedbacks as $fb): ?>
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
              <div class="card-body text-start">
                <h6 class="fw-bold"><?= htmlspecialchars($fb['customer_name']) ?></h6>
                <p><?= nl2br(htmlspecialchars($fb['feedback'])) ?></p>
                <small class="text-muted"><?= $fb['created_at'] ?></small>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p class="text-muted">Chưa có phản hồi nào.</p>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="pt-5 pb-3">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Về chúng tôi</h5>
        <p>Shop Nước Hoa DA cung cấp các dòng nước hoa chính hãng, giúp bạn tự tin và tỏa sáng mỗi ngày.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Chính sách</h5>
        <ul class="list-unstyled">
          <li><a href="#">Chính sách đổi trả</a></li>
          <li><a href="#">Bảo mật thông tin</a></li>
          <li><a href="#">Giao hàng toàn quốc</a></li>
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

</div> <!-- END site-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
