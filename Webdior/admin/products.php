<?php
/**
 * TRANG QUẢN LÝ SẢN PHẨM
 * 
 * Giao diện đơn giản để xem và quản lý sản phẩm
 * Có thể thêm, sửa, xóa sản phẩm
 */

session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

require_once '../config/database.php';

// Xử lý thêm sản phẩm mới
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'add_product') {
    try {
        $product_code = $_POST['product_code'];
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $brand_id = (int)$_POST['brand_id'];
        $category_id = (int)$_POST['category_id'];
        $price = (float)$_POST['price'];
        $sale_price = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
        $volume = $_POST['volume'];
        $concentration = $_POST['concentration'];
        $gender = $_POST['gender'];
        $duration = $_POST['duration'];
        $sillage = $_POST['sillage'];
        $description = $_POST['description'];
        $main_image = $_POST['main_image'];
        $is_featured = 1; // Luôn đánh dấu sản phẩm nổi bật
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $stock_quantity = (int)$_POST['stock_quantity'];
        
        $sql = "INSERT INTO products (product_code, name, slug, brand_id, category_id, price, sale_price, volume, concentration, gender, duration, sillage, description, main_image, is_featured, is_active, stock_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [$product_code, $name, $slug, $brand_id, $category_id, $price, $sale_price, $volume, $concentration, $gender, $duration, $sillage, $description, $main_image, $is_featured, $is_active, $stock_quantity];
        
        executeQuery($sql, $params);
        $success_message = "Thêm sản phẩm thành công!";
    } catch (Exception $e) {
        $error_message = "Lỗi: " . $e->getMessage();
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $product_id = (int)$_GET['delete'];
        executeQuery("DELETE FROM products WHERE id = ?", [$product_id]);
        $success_message = "Xóa sản phẩm thành công!";
    } catch (Exception $e) {
        $error_message = "Lỗi xóa sản phẩm: " . $e->getMessage();
    }
}

// Lấy danh sách sản phẩm
$products = fetchAll("
    SELECT p.*, b.name as brand_name, c.name as category_name
    FROM products p
    LEFT JOIN brands b ON p.brand_id = b.id
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
");

// Lấy danh sách thương hiệu và danh mục
$brands = fetchAll("SELECT * FROM brands WHERE is_active = 1 ORDER BY name");
$categories = fetchAll("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - DIOR Perfume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: #f8f9fa;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .status-badge {
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 admin-sidebar p-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-crown text-warning"></i>
                        Admin Panel
                    </h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="products.php">
                        <i class="fas fa-box me-2"></i>Sản phẩm
                    </a>
                    <a class="nav-link" href="../test-database.php">
                        <i class="fas fa-database me-2"></i>Test Database
                    </a>
                    <a class="nav-link" href="../index.php">
                        <i class="fas fa-home me-2"></i>Về trang chủ
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-box me-2"></i>Quản lý sản phẩm</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                    </button>
                </div>

                <!-- Thông báo -->
                <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $success_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Danh sách sản phẩm -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách sản phẩm (<?= count($products) ?> sản phẩm)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($products)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có sản phẩm nào</h5>
                            <p class="text-muted">Hãy thêm sản phẩm đầu tiên của bạn!</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Mã SP</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Thương hiệu</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product['main_image']): ?>
                                            <img src="<?= htmlspecialchars($product['main_image']) ?>" 
                                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                                 class="product-image">
                                            <?php else: ?>
                                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <code><?= htmlspecialchars($product['product_code']) ?></code>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($product['name']) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($product['volume']) ?> - <?= htmlspecialchars($product['concentration']) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($product['brand_name']) ?></td>
                                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                                        <td>
                                            <strong><?= number_format($product['price'], 0, ',', '.') ?>₫</strong>
                                            <?php if ($product['sale_price']): ?>
                                            <br><small class="text-success">KM: <?= number_format($product['sale_price'], 0, ',', '.') ?>₫</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product['is_active']): ?>
                                            <span class="badge bg-success status-badge">Hoạt động</span>
                                            <?php else: ?>
                                            <span class="badge bg-secondary status-badge">Tạm dừng</span>
                                            <?php endif; ?>
                                            
                                            <?php if ($product['is_featured']): ?>
                                            <br><span class="badge bg-warning status-badge">Nổi bật</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="../page/san-pham.php?id=<?= $product['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   title="Xem sản phẩm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="?delete=<?= $product['id'] ?>" 
                                                   class="btn btn-outline-danger" 
                                                   title="Xóa sản phẩm"
                                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm sản phẩm -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_product">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã sản phẩm *</label>
                                <input type="text" class="form-control" name="product_code" required>
                                <small class="form-text text-muted">VD: DIOR001, DIOR002...</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tên sản phẩm *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">URL Slug *</label>
                                <input type="text" class="form-control" name="slug" required>
                                <small class="form-text text-muted">VD: dior-sauvage-edt</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thương hiệu *</label>
                                <select class="form-select" name="brand_id" required>
                                    <option value="">Chọn thương hiệu</option>
                                    <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Danh mục *</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính *</label>
                                <select class="form-select" name="gender" required>
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Unisex">Unisex</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá sản phẩm *</label>
                                <input type="number" class="form-control" name="price" min="0" step="1000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá khuyến mãi</label>
                                <input type="number" class="form-control" name="sale_price" min="0" step="1000">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dung tích</label>
                                <input type="text" class="form-control" name="volume" placeholder="VD: 100ml">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nồng độ</label>
                                <input type="text" class="form-control" name="concentration" placeholder="VD: Eau de Toilette">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Độ lưu hương</label>
                                <input type="text" class="form-control" name="duration" placeholder="VD: 6-8h">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Độ tỏa hương</label>
                                <input type="text" class="form-control" name="sillage" placeholder="VD: 1 sải tay">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh chính</label>
                            <input type="text" class="form-control" name="main_image" placeholder="/Webdior/images/products/product1.jpg">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số lượng tồn kho</label>
                                <input type="number" class="form-control" name="stock_quantity" min="0" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" checked disabled>
                                    <label class="form-check-label" for="is_featured">
                                        Sản phẩm nổi bật <small class="text-success">(Tự động)</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt sản phẩm
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Lưu sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
