<?php
/**
 * KIỂM TRA SẢN PHẨM ID 1
 */

require_once 'config/database.php';

echo "<h2>🔍 Kiểm tra sản phẩm ID 1</h2>";

try {
    $pdo = getDBConnection();
    echo "<p style='color: green;'>✅ Database connection OK</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Kiểm tra sản phẩm ID 1
$productId = 1;

echo "<h3>📦 Kiểm tra sản phẩm ID: $productId</h3>";

try {
    $product = fetchOne("
        SELECT p.*, b.name as brand_name, c.name as category_name
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?
    ", [$productId]);
    
    if ($product) {
        echo "<p style='color: green;'>✅ Tìm thấy sản phẩm ID $productId!</p>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><td><strong>ID:</strong></td><td>" . $product['id'] . "</td></tr>";
        echo "<tr><td><strong>Mã SP:</strong></td><td>" . htmlspecialchars($product['product_code']) . "</td></tr>";
        echo "<tr><td><strong>Tên:</strong></td><td>" . htmlspecialchars($product['name']) . "</td></tr>";
        echo "<tr><td><strong>Thương hiệu:</strong></td><td>" . htmlspecialchars($product['brand_name']) . "</td></tr>";
        echo "<tr><td><strong>Danh mục:</strong></td><td>" . htmlspecialchars($product['category_name']) . "</td></tr>";
        echo "<tr><td><strong>Giá:</strong></td><td>" . number_format($product['price'], 0, ',', '.') . "₫</td></tr>";
        echo "<tr><td><strong>Trạng thái:</strong></td><td>" . ($product['is_active'] ? 'Hoạt động' : 'Tạm dừng') . "</td></tr>";
        echo "</table>";
        
        echo "<h3>🔗 Test Links:</h3>";
        echo "<p><a href='page/san-pham.php?id=" . $product['id'] . "' target='_blank'>Xem trang sản phẩm</a></p>";
        echo "<p><a href='api/get-product.php?id=" . $product['id'] . "' target='_blank'>Xem API response</a></p>";
        
    } else {
        echo "<p style='color: red;'>❌ Không tìm thấy sản phẩm ID: $productId</p>";
        
        // Hiển thị tất cả sản phẩm có sẵn
        echo "<h3>📋 Tất cả sản phẩm trong database:</h3>";
        $allProducts = fetchAll("
            SELECT p.id, p.product_code, p.name, b.name as brand_name, c.name as category_name
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.id
        ");
        
        if (empty($allProducts)) {
            echo "<p style='color: red;'>❌ Không có sản phẩm nào trong database!</p>";
            echo "<p><strong>Giải pháp:</strong></p>";
            echo "<ul>";
            echo "<li>Import file SQL: <code>database/dior_perfume_database_flexible.sql</code></li>";
            echo "<li>Thêm sản phẩm qua admin: <a href='admin/products.php'>Admin Panel</a></li>";
            echo "</ul>";
        } else {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Mã SP</th><th>Tên</th><th>Thương hiệu</th><th>Danh mục</th><th>Test</th></tr>";
            
            foreach ($allProducts as $p) {
                echo "<tr>";
                echo "<td>" . $p['id'] . "</td>";
                echo "<td>" . htmlspecialchars($p['product_code']) . "</td>";
                echo "<td>" . htmlspecialchars($p['name']) . "</td>";
                echo "<td>" . htmlspecialchars($p['brand_name']) . "</td>";
                echo "<td>" . htmlspecialchars($p['category_name']) . "</td>";
                echo "<td><a href='page/san-pham.php?id=" . $p['id'] . "' target='_blank'>Test ID " . $p['id'] . "</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "<h3>🧪 Test API:</h3>";
echo "<p><a href='api/get-product.php?id=$productId' target='_blank'>Test API cho ID $productId</a></p>";

echo "<h3>🔙 Links:</h3>";
echo "<p><a href='admin/products.php'>Admin Panel</a> | <a href='test-database.php'>Test Database</a></p>";
?>
