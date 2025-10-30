<?php
session_start();
require '../admincp/config.php';

// ✅ Bắt buộc đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php?redirect=../Pages/thanhtoan.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';
$cart_items = [];
$total = 0;
$product = null;
$cart_count = 0;

// ✅ Nếu là mua ngay
if (isset($_GET['mode']) && $_GET['mode'] === 'buy_now' && isset($_SESSION['buy_now'])) {
    $product_id = $_SESSION['buy_now']['id'] ?? 0;
    if ($product_id) {
        $stmt = $pdo->prepare("
            SELECT p.id, p.name, p.price, pi.src AS image_src
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
            WHERE p.id = ?
        ");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product) $total = $product['price'];
    }
} else {
    // ✅ Lấy từ giỏ hàng nếu không mua ngay
    $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart) {
        $cart_id = $cart['id'];
        $stmt = $pdo->prepare("
            SELECT ci.id AS cart_item_id, ci.quantity, ci.price,
                   p.name, p.id AS product_id,
                   pi.src AS image_src
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
            WHERE ci.cart_id = ?
        ");
        $stmt->execute([$cart_id]);
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $cart_count = count($cart_items);
    }
}
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

<video autoplay muted loop playsinline class="video-background">
  <source src="../Videos/hoadaoroi.mp4" type="video/mp4">
</video>

<div class="site-content">

  <!-- 🔝 TOP BAR -->
  <div class="bg-brand text-light py-2">
    <div class="container d-flex justify-content-between align-items-center small">
      <span><i class="bi bi-shop"></i> Shop Nước Hoa DA</span>
      <div class="d-flex gap-3 align-items-center">
        <span>Xin chào, <strong><?= htmlspecialchars($user_name) ?></strong>!</span>
        <a href="dangxuat.php" class="text-light">Đăng xuất</a>
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

  <!-- 🧾 THANH TOÁN -->
  <section class="py-5">
    <div class="container bg-white p-4 rounded shadow">
      <h2 class="fw-bold text-center mb-4 text-brand">🧾 Thanh toán đơn hàng</h2>

      <div class="row g-4">
        <!-- 🛍️ Sản phẩm -->
        <div class="col-md-6 border-end">
          <h5 class="mb-3 fw-bold">Sản phẩm</h5>

          <?php if ($product): ?>
            <!-- Mua ngay -->
            <div class="d-flex align-items-center mb-3">
              <img src="../<?= htmlspecialchars($product['image_src'] ?? 'Images/nuochoa/no-images.jpg') ?>" 
                   alt="<?= htmlspecialchars($product['name']) ?>" 
                   style="width:100px;height:100px;object-fit:cover;" class="rounded">
              <div class="ms-3">
                <h6><?= htmlspecialchars($product['name']) ?></h6>
                <p class="text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
              </div>
            </div>
            <div class="text-end border-top pt-2 fw-bold">
              Tổng cộng: <span class="text-danger"><?= number_format($total, 0, ',', '.') ?>đ</span>
            </div>

          <?php elseif ($cart_items): ?>
            <!-- Từ giỏ hàng -->
            <div class="table-responsive">
              <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                  <tr>
                    <th>Hình</th><th>Tên</th><th>Giá</th><th>SL</th><th>Thành tiền</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cart_items as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <tr>
                      <td><img src="../<?= htmlspecialchars($item['image_src'] ?? 'Images/nuochoa/no-images.jpg') ?>" width="60"></td>
                      <td><?= htmlspecialchars($item['name']) ?></td>
                      <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                      <td><?= $item['quantity'] ?></td>
                      <td class="fw-bold text-danger"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="table-secondary">
                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                    <td class="fw-bold text-danger"><?= number_format($total, 0, ',', '.') ?>đ</td>
                  </tr>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="alert alert-info text-center">
              Không có sản phẩm để thanh toán.
              <a href="../index.php" class="alert-link">Quay lại mua sắm</a>.
            </div>
          <?php endif; ?>
        </div>

        <!-- 🚚 Thông tin giao hàng -->
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

            <input type="hidden" name="product_id" value="<?= $product['id'] ?? '' ?>">
            <input type="hidden" name="total" value="<?= $total ?>">

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

  <footer class="pt-5 pb-3 text-center text-light">
    <small>© 2025 Shop Nước Hoa DA - All rights reserved.</small>
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
