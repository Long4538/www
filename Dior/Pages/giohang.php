<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng của bạn - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">
</head>

<body>

  <!-- 🎬 Video nền -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <div class="site-content">

    <!-- 🟣 Thanh top -->
    <div class="bg-brand text-light py-2">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
        <div class="d-flex gap-3 align-items-center">
          <?php if (isset($_SESSION['user_name'])): ?>
            <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></span>
            <a href="dangxuat.php" class="text-light">Đăng xuất</a>
          <?php else: ?>
            <a href="dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="dangky.php" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng ký</a>
          <?php endif; ?>
          <a href="Pages/muangay.php?id=<?= $sp['id'] ?>" class="btn btn-brand btn-sm">Mua ngay</a>
        </div>
      </div>
    </div>

    <!-- 🔵 Header -->
    <header class="py-3 bg-light border-bottom">
      <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
          <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
        </a>

        <form class="d-flex flex-grow-1 mx-3" role="search" action="timkiem.php" method="get">
          <input class="form-control me-2" name="q" type="search" placeholder="Tìm kiếm sản phẩm...">
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

    <!-- 🔸 Menu -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
      <div class="container">
        <a class="navbar-brand fw-bold text-brand" href="../index.php">Trang chủ</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="gioithieu.php">Giới thiệu</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Nước hoa</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="nuochoanam.php">Nước hoa Nam</a></li>
                <li><a class="dropdown-item" href="nuochoanu.php">Nước hoa Nữ</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="khuyenmai.php">Khuyến mãi</a></li>
            <li class="nav-item"><a class="nav-link" href="phukien.php">Phụ kiện</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- 🛒 Nội dung giỏ hàng -->
    <section class="py-5">
      <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center mb-4 fw-bold text-brand">🛒 Giỏ hàng của bạn</h3>

        <?php if (empty($cart)): ?>
          <div class="alert alert-info text-center">Giỏ hàng của bạn đang trống.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-dark">
                <tr>
                  <th>Hình ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Dung tích</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart as $item): ?>
                  <?php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                  ?>
                  <tr>
                    <td><img src="../<?= htmlspecialchars($item['image']) ?>" width="70" class="rounded shadow-sm"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['variant'] ?? '-') ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                    <td><?= $item['quantity'] ?></td>
                    <td class="fw-bold text-danger"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                  </tr>
                <?php endforeach; ?>
                <tr class="table-secondary">
                  <td colspan="5" class="text-end fw-bold">Tổng cộng:</td>
                  <td class="fw-bold text-danger"><?= number_format($total, 0, ',', '.') ?>đ</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="../index.php" class="btn btn-secondary">
              ← Tiếp tục mua sắm
            </a>
            <a href="thanhtoan.php" class="btn btn-success">
              <i class="bi bi-credit-card"></i> Thanh toán
            </a>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Footer -->
    <footer class="pt-5 pb-3 text-center">
      <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
