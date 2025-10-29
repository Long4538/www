<?php
session_start();
require '../admincp/config.php';

// ✅ Nếu chưa đăng nhập → bắt buộc đăng nhập
if (!isset($_SESSION['user_name'])) {
  header("Location: dangnhap.php?redirect=../Pages/thanhtoan.php");
  exit;
}

// ✅ Lấy sản phẩm nếu đi từ trang "Mua ngay"
$product_id = $_GET['id'] ?? 0;
$product = null;

if ($product_id) {
  $stmt = $pdo->prepare("
    SELECT p.*, pi.src AS image_src
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.id = ?
  ");
  $stmt->execute([$product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ✅ Đếm số sản phẩm trong giỏ
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thanh toán - Shop Nước Hoa DA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

  <!-- 🎬 VIDEO NỀN -->
  <video autoplay muted loop playsinline class="video-background">
    <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
  </video>

  <div class="site-content">

    <!-- 🧩 TOP BAR -->
    <div class="bg-brand text-light py-2">
      <div class="container d-flex justify-content-between align-items-center small">
        <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
        <div class="d-flex gap-3 align-items-center">
          <?php if (isset($_SESSION['user_name'])): ?>
            <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</span>
            <a href="dangxuat.php" class="text-light">Đăng xuất</a>
          <?php else: ?>
            <a href="dangnhap.php" class="text-light text-decoration-none"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="dangky.php" class="text-light text-decoration-none"><i class="bi bi-person-plus"></i> Đăng ký</a>
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

    <!-- 🧩 HEADER -->
    <header class="py-3 bg-light border-bottom">
      <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <a href="../index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
          <img src="../Images/logo/logo-1.png" alt="Logo" height="60">
        </a>

        <!-- 🔍 Ô tìm kiếm -->
        <form class="d-flex flex-grow-1 mx-3" role="search" method="GET" action="timkiem.php">
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

    <!-- 🧭 NAVBAR -->
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
            <li class="nav-item"><a class="nav-link" href="khachhang.php">Khách hàng</a></li>
            <li class="nav-item"><a class="nav-link" href="lienhe.php">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- 🧾 THANH TOÁN -->
    <section class="py-5">
      <div class="container bg-white p-4 rounded shadow">
        <h2 class="fw-bold text-center mb-4 text-brand">🧾 Thanh toán đơn hàng</h2>

        <div class="row g-4">
          <!-- 🛍️ Thông tin sản phẩm -->
          <div class="col-md-6 border-end">
            <h5 class="mb-3 fw-bold">Sản phẩm</h5>

            <?php if ($product): ?>
              <!-- 🛒 Mua ngay 1 sản phẩm -->
              <div class="d-flex align-items-center mb-3">
                <img src="../<?= htmlspecialchars($product['image_src'] ?? 'Images/nuochoa/no-images.jpg') ?>"
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                <div class="ms-3">
                  <h6><?= htmlspecialchars($product['name']) ?></h6>
                  <p class="text-danger fw-bold mb-1"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                </div>
              </div>
              <div class="border-top pt-2 text-end fw-bold">
                Tổng cộng: <span class="text-danger"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
              </div>

            <?php elseif (!empty($_SESSION['cart'])): ?>
              <!-- 🧺 Thanh toán từ giỏ hàng -->
              <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
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
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item):
                      $subtotal = $item['price'] * $item['quantity'];
                      $total += $subtotal;
                    ?>
                    <tr>
                      <td><img src="../<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded shadow-sm"></td>
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
            <?php else: ?>
              <div class="alert alert-info text-center">
                Không có sản phẩm nào để thanh toán.
                <a href="../index.php" class="alert-link">Quay lại mua sắm</a>.
              </div>
            <?php endif; ?>
          </div>

          <!-- 📦 Thông tin giao hàng -->
          <div class="col-md-6">
            <h5 class="mb-3 fw-bold">Thông tin giao hàng</h5>
            <form action="thanhtoan_xuly.php" method="post">
              <div class="mb-3">
                <label class="form-label">Họ và tên:</label>
                <input type="text" name="fullname" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Số điện thoại:</label>
                <input type="tel" name="phone" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Địa chỉ nhận hàng:</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Phương thức thanh toán:</label>
                <select name="payment" class="form-select" required>
                  <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                  <option value="bank">Chuyển khoản ngân hàng</option>
                  <option value="momo">Ví MoMo</option>
                </select>
              </div>

              <!-- ẩn ID sản phẩm nếu là “mua ngay” -->
              <input type="hidden" name="product_id" value="<?= $product['id'] ?? '' ?>">
              <!-- ẩn tổng tiền (nếu có) -->
              <input type="hidden" name="total" value="<?= $total ?? ($product['price'] ?? 0) ?>">

              <div class="text-end mt-4">
                <button type="submit" class="btn btn-danger px-4">
                  <i class="bi bi-check2-circle"></i> Xác nhận đặt hàng
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- 🧩 FOOTER -->
    <footer class="pt-5 pb-3 text-center text-light">
      <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
    </footer>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
