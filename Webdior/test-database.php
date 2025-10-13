<?php
/**
 * FILE TEST KẾT NỐI DATABASE
 * 
 * File này dùng để test kết nối và hiển thị dữ liệu từ database
 * Chỉ sử dụng trong môi trường development
 */

// Chỉ cho phép truy cập từ localhost
if ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1') {
    die('Chỉ cho phép truy cập từ localhost');
}

require_once 'config/database.php';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Database - DIOR Perfume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-success { color: #28a745; }
        .status-error { color: #dc3545; }
        .code-block { background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">🧪 Test Database - DIOR Perfume</h1>
        
        <!-- Test kết nối -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>🔌 Test Kết Nối Database</h3>
            </div>
            <div class="card-body">
                <?php
                try {
                    $pdo = getDBConnection();
                    echo '<p class="status-success">✅ <strong>Kết nối database thành công!</strong></p>';
                    echo '<p>Host: ' . DB_HOST . '</p>';
                    echo '<p>Database: ' . DB_NAME . '</p>';
                    echo '<p>Charset: ' . DB_CHARSET . '</p>';
                } catch (Exception $e) {
                    echo '<p class="status-error">❌ <strong>Lỗi kết nối database:</strong></p>';
                    echo '<div class="code-block">' . htmlspecialchars($e->getMessage()) . '</div>';
                }
                ?>
            </div>
        </div>

        <!-- Test dữ liệu -->
        <?php if (testDBConnection()): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3>📊 Test Dữ Liệu</h3>
            </div>
            <div class="card-body">
                <?php
                // Test đếm bảng
                $tables = [
                    'brands' => 'Thương hiệu',
                    'categories' => 'Danh mục',
                    'products' => 'Sản phẩm',
                    'product_images' => 'Hình ảnh sản phẩm',
                    'fragrance_notes' => 'Hương thơm',
                    'related_products' => 'Sản phẩm liên quan',
                    'users' => 'Người dùng',
                    'orders' => 'Đơn hàng',
                    'settings' => 'Cài đặt'
                ];
                
                echo '<div class="row">';
                foreach ($tables as $table => $name) {
                    try {
                        $count = fetchOne("SELECT COUNT(*) as count FROM $table");
                        echo '<div class="col-md-4 mb-2">';
                        echo '<span class="badge bg-primary">' . $name . ': ' . $count['count'] . '</span>';
                        echo '</div>';
                    } catch (Exception $e) {
                        echo '<div class="col-md-4 mb-2">';
                        echo '<span class="badge bg-danger">' . $name . ': Lỗi</span>';
                        echo '</div>';
                    }
                }
                echo '</div>';
                ?>
            </div>
        </div>

        <!-- Hiển thị sản phẩm -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>🛍️ Sản Phẩm Mẫu</h3>
            </div>
            <div class="card-body">
                <?php
                $products = fetchAll("
                    SELECT p.*, b.name as brand_name, c.name as category_name
                    FROM products p
                    LEFT JOIN brands b ON p.brand_id = b.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    ORDER BY p.id
                    LIMIT 5
                ");
                
                if ($products):
                ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Giới tính</th>
                                <th>Nổi bật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['brand_name']) ?></td>
                                <td><?= htmlspecialchars($product['category_name']) ?></td>
                                <td><?= number_format($product['price'], 0, ',', '.') ?>₫</td>
                                <td><?= $product['gender'] ?></td>
                                <td><?= $product['is_featured'] ? '✅' : '❌' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">Không có sản phẩm nào trong database.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Test API -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>🔌 Test API Endpoints</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Lấy sản phẩm theo ID:</h5>
                        <div class="code-block">
                            GET /Webdior/api/get-product.php?id=1
                        </div>
                        <a href="api/get-product.php?id=1" target="_blank" class="btn btn-sm btn-primary">Test API</a>
                    </div>
                    <div class="col-md-6">
                        <h5>Lấy danh sách sản phẩm:</h5>
                        <div class="code-block">
                            GET /Webdior/api/get-products.php?limit=4
                        </div>
                        <a href="api/get-products.php?limit=4" target="_blank" class="btn btn-sm btn-primary">Test API</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin cấu hình -->
        <div class="card">
            <div class="card-header">
                <h3>⚙️ Thông Tin Cấu Hình</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Database Config:</h5>
                        <ul>
                            <li><strong>Host:</strong> <?= DB_HOST ?></li>
                            <li><strong>Database:</strong> <?= DB_NAME ?></li>
                            <li><strong>User:</strong> <?= DB_USER ?></li>
                            <li><strong>Charset:</strong> <?= DB_CHARSET ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>PHP Info:</h5>
                        <ul>
                            <li><strong>PHP Version:</strong> <?= PHP_VERSION ?></li>
                            <li><strong>PDO Available:</strong> <?= extension_loaded('pdo') ? '✅' : '❌' ?></li>
                            <li><strong>PDO MySQL:</strong> <?= extension_loaded('pdo_mysql') ? '✅' : '❌' ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="alert alert-danger">
            <h4>❌ Không thể kết nối database!</h4>
            <p>Vui lòng kiểm tra:</p>
            <ul>
                <li>MySQL server đã chạy chưa?</li>
                <li>Database <code>dior_perfume_db</code> đã được tạo chưa?</li>
                <li>File <code>config/database.php</code> có đúng cấu hình không?</li>
                <li>User database có quyền truy cập không?</li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="index.php" class="btn btn-primary">🏠 Về Trang Chủ</a>
            <a href="page/san-pham.php?id=1" class="btn btn-success">🛍️ Xem Sản Phẩm</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
