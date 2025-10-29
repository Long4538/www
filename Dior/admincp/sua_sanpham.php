<?php
session_start();
require_once '../admincp/config.php'; // đảm bảo đường dẫn đúng

// Kiểm tra quyền admin
if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    header('Location: ../Index.php');
    exit;
}

// Lấy ID sản phẩm từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: quanly_sanpham.php');
    exit;
}

// Lấy thông tin sản phẩm hiện tại
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    header('Location: quanly_sanpham.php');
    exit;
}

// Xử lý POST khi admin gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $brand = trim($_POST['brand'] ?? '');
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Cập nhật sản phẩm
    $update = $pdo->prepare("UPDATE products SET name=?, price=?, brand=?, is_active=?, updated_at=NOW() WHERE id=?");
    $update->execute([$name, $price, $brand, $is_active, $id]);

    // Xử lý ảnh đại diện nếu có upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'uploads/products_' . $id . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $filename);

        // Cập nhật bảng product_images
        $pdo->prepare("UPDATE product_images SET is_primary=0 WHERE product_id=?")->execute([$id]);
        $stmt_img = $pdo->prepare("INSERT INTO product_images (product_id, src, is_primary) VALUES (?, ?, 1)");
        $stmt_img->execute([$id, $filename]);
    }

    header("Location: quanly_sanpham.php?updated=1");
    exit;
}

// Lấy ảnh hiện tại (nếu có)
$stmt_img = $pdo->prepare("SELECT src FROM product_images WHERE product_id=? AND is_primary=1");
$stmt_img->execute([$id]);
$current_img = $stmt_img->fetchColumn();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .container { max-width: 700px; }
    img { border-radius: 8px; }
  </style>
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4 text-primary fw-bold">✏️ Sửa sản phẩm</h2>

  <div class="mb-3">
    <a href="quanly_sanpham.php" class="btn btn-secondary">← Quay lại danh sách</a>
  </div>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Tên sản phẩm</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Giá</label>
      <input type="number" step="1000" name="price" class="form-control" required value="<?= htmlspecialchars($product['price']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Thương hiệu</label>
      <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($product['brand']) ?>">
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" name="is_active" id="is_active" <?= $product['is_active'] ? 'checked' : '' ?>>
      <label class="form-check-label" for="is_active">Hiển thị sản phẩm</label>
    </div>

    <div class="mb-3">
      <label class="form-label">Ảnh đại diện (tùy chọn)</label>
      <input type="file" name="image" class="form-control">
      <?php if ($current_img): ?>
        <div class="mt-2">
          <img src="../<?= htmlspecialchars($current_img) ?>" alt="Ảnh hiện tại" width="150">
        </div>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
