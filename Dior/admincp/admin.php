<?php
session_start();

// Chỉ cho phép admin truy cập
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../Index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang quản trị - Shop Nước Hoa DA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .admin-container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      padding: 40px;
    }
    .list-group-item {
      font-size: 1.1rem;
      padding: 12px 18px;
    }
    h2 {
      color: #d63384;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <h2 class="text-center mb-4">👑 Chào Mừng: <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
    <hr>
    <div class="list-group">
      <a href="../admincp/quanly_sanpham.php" class="list-group-item list-group-item-action">📦 Quản lý sản phẩm</a>
      <a href="quanly_nguoidung.php" class="list-group-item list-group-item-action">👤 Quản lý người dùng</a>
      <a href="../admincp/orders.php" class="list-group-item list-group-item-action">🧾 Quản lý đơn hàng</a>
      <a href="../admincp/add_promo.php" class="list-group-item list-group-item-action">🎉 Thêm sản phẩm khuyến mãi</a>

      <a href="../Pages/dangxuat.php" class="list-group-item list-group-item-action text-danger">🚪 Đăng xuất</a>
    </div>
  </div>
</body>
</html>
