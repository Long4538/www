<?php
session_start();

// Kết nối database
require_once __DIR__ . '/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    header('Location: ../Index.php');
    exit;
}

// Lấy danh sách sản phẩm + ảnh đại diện (is_primary = 1)
$stmt = $pdo->query("
    SELECT p.*, pi.src AS image_src
    FROM products p
    LEFT JOIN product_images pi 
        ON p.id = pi.product_id AND pi.is_primary = 1
    ORDER BY p.id DESC
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">📦 Quản lý sản phẩm</h2>

    <div class="mb-3">
      <a href="../admincp/admin.php" class="btn btn-secondary">← Quay lại</a>
      <a href="them_sanpham.php" class="btn btn-primary">+ Thêm sản phẩm</a>
    </div>

    <?php if (empty($products)): ?>
      <div class="alert alert-info text-center">Chưa có sản phẩm nào.</div>
    <?php else: ?>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light text-center">
          <tr>
            <th width="5%">ID</th>
            <th width="25%">Tên sản phẩm</th>
            <th width="10%">Giá</th>
            <th width="15%">Ảnh</th>
            <th width="15%">Thương hiệu</th>
            <th width="15%">Trạng thái</th>
            <th width="15%">Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td class="text-center"><?= $p['id'] ?></td>
              <td><?= htmlspecialchars($p['name']) ?></td>
              <td class="text-danger fw-bold text-center">
                <?= number_format($p['price'], 0, ',', '.') ?>đ
              </td>
              <td class="text-center">
                <?php
                  $img = $p['image_src'] ?? '';
                  if ($img) {
                      echo "<img src=\"../$img\" width=\"80\" alt=\"Ảnh sản phẩm\" class=\"rounded shadow-sm\">";
                  } else {
                      echo "<span class='text-muted'>Không có</span>";
                  }
                ?>
              </td>
              <td class="text-center"><?= htmlspecialchars($p['brand'] ?: '-') ?></td>
              <td class="text-center">
                <?= $p['is_active'] ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' ?>
              </td>
              <td class="text-center">
                <a href="sua_sanpham.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="xoa_sanpham.php?id=<?= $p['id'] ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
