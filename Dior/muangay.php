<?php
session_start();
require 'admincp/config.php';

// ✅ 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
  echo "<script>
    alert('⚠️ Vui lòng đăng nhập để mua sản phẩm!');
    window.location.href = 'Pages/dangnhap.php?redirect=" . urlencode($_SERVER['REQUEST_URI']) . "';
  </script>";
  exit;
}

// ✅ 2. Lấy ID sản phẩm
$product_id = $_GET['id'] ?? 0;
if (!$product_id) {
  header("Location: index.php");
  exit;
}

// ✅ 3. Lấy thông tin sản phẩm
$stmt = $pdo->prepare("
  SELECT p.*, pi.src AS image_src
  FROM products p
  LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
  WHERE p.id = ?
");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
  header("Location: index.php");
  exit;
}

// ✅ 4. Khi người dùng bấm "Mua ngay"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

  // ✅ Tạo session "buy_now" riêng, không đụng đến giỏ hàng
  $_SESSION['buy_now'] = [
    'id'       => $product['id'],
    'name'     => $product['name'],
    'price'    => $product['price'],
    'image'    => $product['image_src'] ?? 'Images/nuochoa/no-images.jpg',
    'quantity' => $quantity
  ];

  // ✅ Chuyển hướng đến trang thanh toán (chế độ mua ngay)
  header("Location: Pages/thanhtoan.php?mode=buy_now");
  exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Mua ngay - <?= htmlspecialchars($product['name']) ?> | Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="Css/style.css">
</head>

<body>
  <video autoplay muted loop playsinline class="video-background">
    <source src="Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <div class="site-content">
    <!-- ========== TOP BAR ========== -->
    <div class="bg-brand text-light py-2">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
        <div class="d-flex gap-3 align-items-center">
          <?php if (isset($_SESSION['user_name'])): ?>
            <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
            <a href="Pages/dangxuat.php" class="text-light">Đăng xuất</a>
          <?php else: ?>
            <a href="Pages/dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="Pages/dangky.php" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng ký</a>
          <?php endif; ?>

          <?php
          $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
          ?>
          <a href="Pages/giohang.php" class="text-light text-decoration-none position-relative">
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

    <!-- HEADER -->
    <header class="py-3 bg-light border-bottom">
      <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
          <img src="Images/logo/logo-1.png" alt="Logo" height="60">
        </a>

        <form class="d-flex flex-grow-1 mx-3" role="search" method="GET" action="Pages/timkiem.php">
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

    <!-- ========== CHI TIẾT SẢN PHẨM ========== -->
    <section class="py-5">
      <div class="container">
        <div class="row g-5 align-items-center bg-white p-4 rounded shadow">
          <div class="col-md-5 text-center">
            <img src="<?= htmlspecialchars($product['image_src'] ?? 'Images/nuochoa/no-images.jpg') ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>"
                 class="img-fluid rounded-3 shadow-sm" style="max-height: 400px; object-fit: cover;">
          </div>

          <div class="col-md-7">
            <h2 class="fw-bold text-brand mb-3"><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted"><?= htmlspecialchars($product['short_description']) ?></p>

            <div class="mb-3">
              <span class="fw-bold text-danger fs-4"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
            </div>

            <form method="post">
              <div class="mb-3">
                <label class="form-label fw-bold">Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1" class="form-control" style="max-width: 120px;">
              </div>

              <button type="submit" class="btn btn-danger w-100 mt-3">
                <i class="bi bi-lightning-charge"></i> Mua ngay
              </button>
            </form>
          </div>
        </div>

        <div class="mt-5 bg-white p-4 rounded shadow-sm">
          <h4 class="fw-bold mb-3">Mô tả chi tiết</h4>
          <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="pt-5 pb-3">
      <div class="container text-center">
        <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
