<?php
session_start();
require 'config.php';

// Chỉ admin mới được truy cập
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../index.php');
    exit;
}

// Xử lý form khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $promo_price = $_POST['promo_price'];
    $is_active = 1; // sản phẩm đang bán
    $is_promo = 1;  // sản phẩm khuyến mãi

    // Thêm sản phẩm vào bảng products
    $stmt = $pdo->prepare("INSERT INTO products (name, short_description, price, promo_price, is_active, is_promo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $short_description, $price, $promo_price, $is_active, $is_promo]);

    $product_id = $pdo->lastInsertId();

    // Upload ảnh sản phẩm
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = '../Images/nuochoa/';
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); // tạo thư mục nếu chưa có
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            // Thêm ảnh vào bảng product_images
            $stmt2 = $pdo->prepare("INSERT INTO product_images (product_id, src, is_primary) VALUES (?, ?, 1)");
            $stmt2->execute([$product_id, 'Images/nuochoa/' . $image_name]);
        }
    }

    $success = "Đã thêm sản phẩm khuyến mãi thành công!";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sản phẩm khuyến mãi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Thêm sản phẩm khuyến mãi</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input class="form-control" type="text" name="name" placeholder="Tên sản phẩm" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="text" name="short_description" placeholder="Mô tả ngắn">
        </div>
        <div class="mb-3">
            <input class="form-control" type="number" name="price" placeholder="Giá gốc" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="number" name="promo_price" placeholder="Giá khuyến mãi" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="file" name="image" required>
        </div>
        <button class="btn btn-primary" type="submit">Thêm sản phẩm khuyến mãi</button>
        <a href="admin.php" class="btn btn-secondary ms-2">Trở lại</a>
    </form>
</div>

</body>
</html>
