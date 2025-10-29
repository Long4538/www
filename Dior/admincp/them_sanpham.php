<?php
// -------------------------
// 1️⃣ BẮT ĐẦU PHIÊN LÀM VIỆC (SESSION)
// -------------------------
session_start();

// -------------------------
// 2️⃣ KẾT NỐI CƠ SỞ DỮ LIỆU
// __DIR__ là đường dẫn tuyệt đối đến thư mục hiện tại (admincp)
// => __DIR__ . '/config.php' sẽ trỏ đến file cấu hình database
// -------------------------
require_once __DIR__ . '/config.php';

// -------------------------
// 3️⃣ CHỈ CHO PHÉP QUẢN TRỊ VIÊN (ADMIN) TRUY CẬP
// Nếu chưa đăng nhập hoặc role_id khác 1 => không phải admin
// thì chuyển hướng về trang chủ và dừng thực thi
// -------------------------
if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    header('Location: ../Index.php');
    exit;
}

// -------------------------
// 4️⃣ KHAI BÁO BIẾN THÔNG BÁO
// Biến này dùng để hiển thị thông báo thêm sản phẩm thành công
// -------------------------
$message = '';

// -------------------------
// 5️⃣ KIỂM TRA NẾU NGƯỜI DÙNG ĐÃ GỬI FORM (PHƯƠNG THỨC POST)
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ----------- LẤY DỮ LIỆU TỪ FORM -----------
    // Hàm trim() dùng để loại bỏ khoảng trắng ở đầu và cuối chuỗi
    $sku = trim($_POST['sku']);                          // Mã sản phẩm (SKU)
    $name = trim($_POST['name']);                        // Tên sản phẩm
    $slug = trim($_POST['slug']);                        // Đường dẫn thân thiện (VD: nuoc-hoa-nam)
    $short_description = trim($_POST['short_description']); // Mô tả ngắn
    $description = trim($_POST['description']);          // Mô tả chi tiết
    $brand = trim($_POST['brand']);                      // Thương hiệu

    // ----------- ÉP KIỂU DỮ LIỆU SỐ -----------
    $price = floatval($_POST['price']);                  // Giá gốc (bắt buộc phải nhập)
    
    // Nếu người dùng không nhập giá khuyến mãi thì để null
    $price_sale = $_POST['price_sale'] !== '' ? floatval($_POST['price_sale']) : null;

    $stock = intval($_POST['stock']);                    // Số lượng tồn kho

    // ----------- XỬ LÝ CHECKBOX -----------
    // Nếu admin tick ô “Hiển thị” → gán 1, ngược lại 0
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Nếu tick “Nổi bật” → gán 1, ngược lại 0
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // -------------------------
    // 6️⃣ XỬ LÝ UPLOAD ẢNH (NẾU CÓ)
    // -------------------------
    $image_path = null;  // Khởi tạo biến đường dẫn ảnh

    // Kiểm tra nếu người dùng có chọn ảnh tải lên
    if (!empty($_FILES['image']['name'])) {

        // Thư mục chứa ảnh: ../Images/uploaded/
        $upload_dir = '../Images/uploaded/';

        // Nếu thư mục chưa tồn tại → tự động tạo mới
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        // Tạo tên file duy nhất (tránh bị trùng) bằng hàm uniqid()
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);

        // Nối thành đường dẫn đầy đủ để lưu file
        $target_path = $upload_dir . $filename;

        // Di chuyển file tạm vào thư mục lưu trữ thật
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // Nếu thành công → lưu đường dẫn tương đối để ghi vào DB
            $image_path = 'Images/uploaded/' . $filename;
        }
    }

    // -------------------------
    // 7️⃣ GHI DỮ LIỆU VÀO BẢNG `products`
    // Sử dụng Prepared Statement để tránh lỗi SQL Injection
    // -------------------------
    $stmt = $pdo->prepare("
        INSERT INTO products (
            sku, name, slug, short_description, description, brand, price, price_sale, stock, is_active, is_featured
        ) VALUES (
            :sku, :name, :slug, :short_description, :description, :brand, :price, :price_sale, :stock, :is_active, :is_featured
        )
    ");

    // Thực thi câu lệnh SQL và truyền dữ liệu tương ứng
    $stmt->execute([
        ':sku' => $sku,
        ':name' => $name,
        ':slug' => $slug,
        ':short_description' => $short_description,
        ':description' => $description,
        ':brand' => $brand,
        ':price' => $price,
        ':price_sale' => $price_sale,
        ':stock' => $stock,
        ':is_active' => $is_active,
        ':is_featured' => $is_featured
    ]);

    // -------------------------
    // 8️⃣ LẤY ID SẢN PHẨM VỪA THÊM
    // Dùng cho việc gắn ảnh vào sản phẩm
    // -------------------------
    $product_id = $pdo->lastInsertId();

    // -------------------------
    // 9️⃣ NẾU CÓ ẢNH → GHI VÀO BẢNG `product_images`
    // Bảng này chứa nhiều ảnh cho mỗi sản phẩm
    // -------------------------
    if ($image_path) {
    // Kiểm tra xem sản phẩm này đã có ảnh chính chưa
    $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM product_images WHERE product_id = :pid AND is_primary = 1");
    $check_stmt->execute([':pid' => $product_id]);
    $has_primary = $check_stmt->fetchColumn();

    // Nếu chưa có ảnh chính thì thêm ảnh này làm ảnh chính
    $is_primary = ($has_primary == 0) ? 1 : 0;

    // Thêm ảnh mới vào bảng product_images
    $img_stmt = $pdo->prepare("
        INSERT INTO product_images (product_id, src, alt_text, is_primary)
        VALUES (:pid, :src, :alt, :is_primary)
    ");
    $img_stmt->execute([
        ':pid' => $product_id,
        ':src' => $image_path,
        ':alt' => $name,
        ':is_primary' => $is_primary
    ]);
}


    // -------------------------
    // 🔟 TẠO THÔNG BÁO XÁC NHẬN
    // -------------------------
    $message = "✅ Đã thêm sản phẩm <b>$name</b> thành công!";
}
?>

<!-- =================================== -->
<!--  🔶 GIAO DIỆN HTML HIỂN THỊ FORM -->
<!-- =================================== -->
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sản phẩm - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">

    <!-- Tiêu đề trang -->
    <h2 class="mb-4 text-center text-primary">➕ Thêm sản phẩm mới</h2>

    <!-- Nút quay lại trang danh sách sản phẩm -->
    <a href="quanly_sanpham.php" class="btn btn-secondary mb-3">← Quay lại danh sách</a>

    <!-- Hiển thị thông báo sau khi thêm -->
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- ============================= -->
    <!-- FORM NHẬP THÔNG TIN SẢN PHẨM -->
    <!-- ============================= -->
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Mã SKU -->
            <div class="col-md-4 mb-3">
                <label>Mã SKU</label>
                <input type="text" name="sku" class="form-control" required>
            </div>

            <!-- Tên sản phẩm -->
            <div class="col-md-4 mb-3">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Slug -->
            <div class="col-md-4 mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" required>
            </div>

            <!-- Thương hiệu -->
            <div class="col-md-4 mb-3">
                <label>Thương hiệu</label>
                <input type="text" name="brand" class="form-control">
            </div>

            <!-- Giá -->
            <div class="col-md-4 mb-3">
                <label>Giá</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <!-- Giá khuyến mãi -->
            <div class="col-md-4 mb-3">
                <label>Giá khuyến mãi</label>
                <input type="number" step="0.01" name="price_sale" class="form-control">
            </div>

            <!-- Số lượng tồn kho -->
            <div class="col-md-4 mb-3">
                <label>Tồn kho</label>
                <input type="number" name="stock" class="form-control" value="0">
            </div>

            <!-- Ảnh sản phẩm -->
            <div class="col-md-4 mb-3">
                <label>Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>

        <!-- Mô tả ngắn -->
        <div class="mb-3">
            <label>Mô tả ngắn</label>
            <textarea name="short_description" class="form-control" rows="2"></textarea>
        </div>

        <!-- Mô tả chi tiết -->
        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <!-- Tùy chọn hiển thị / nổi bật -->
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" checked>
            <label class="form-check-label">Hiển thị</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_featured">
            <label class="form-check-label">Nổi bật</label>
        </div>

        <!-- Nút gửi form -->
        <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
    </form>
</div>

</body>
</html>
