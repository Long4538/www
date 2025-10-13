<?php
/**
 * API LẤY DANH SÁCH SẢN PHẨM
 * 
 * Endpoint: /Webdior/api/get-products.php
 * Parameters:
 * - page: Trang hiện tại (default: 1)
 * - limit: Số sản phẩm mỗi trang (default: 12)
 * - category: ID danh mục
 * - brand: ID thương hiệu
 * - gender: Giới tính (Nam, Nữ, Unisex)
 * - featured: Chỉ lấy sản phẩm nổi bật (1/0)
 * - search: Tìm kiếm theo tên
 * - sort: Sắp xếp (price_asc, price_desc, name_asc, name_desc, newest)
 * 
 * Response: JSON
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database config
require_once '../config/database.php';

try {
    // Lấy tham số
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? min(50, max(1, (int)$_GET['limit'])) : 12;
    $category = isset($_GET['category']) ? (int)$_GET['category'] : null;
    $brand = isset($_GET['brand']) ? (int)$_GET['brand'] : null;
    $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
    $featured = isset($_GET['featured']) ? (int)$_GET['featured'] : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    $offset = ($page - 1) * $limit;
    
    // Xây dựng WHERE clause
    $whereConditions = ['p.is_active = 1'];
    $params = [];
    
    if ($category) {
        $whereConditions[] = 'p.category_id = ?';
        $params[] = $category;
    }
    
    if ($brand) {
        $whereConditions[] = 'p.brand_id = ?';
        $params[] = $brand;
    }
    
    if ($gender && in_array($gender, ['Nam', 'Nữ', 'Unisex'])) {
        $whereConditions[] = 'p.gender = ?';
        $params[] = $gender;
    }
    
    if ($featured !== null) {
        $whereConditions[] = 'p.is_featured = ?';
        $params[] = $featured;
    }
    
    if ($search) {
        $whereConditions[] = '(p.name LIKE ? OR p.description LIKE ?)';
        $searchTerm = '%' . $search . '%';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $whereClause = implode(' AND ', $whereConditions);
    
    // Xây dựng ORDER BY clause
    $orderBy = 'p.created_at DESC'; // default
    switch ($sort) {
        case 'price_asc':
            $orderBy = 'p.price ASC';
            break;
        case 'price_desc':
            $orderBy = 'p.price DESC';
            break;
        case 'name_asc':
            $orderBy = 'p.name ASC';
            break;
        case 'name_desc':
            $orderBy = 'p.name DESC';
            break;
        case 'newest':
        default:
            $orderBy = 'p.created_at DESC';
            break;
    }
    
    // Đếm tổng số sản phẩm
    $countSql = "
        SELECT COUNT(*) as total
        FROM products p
        WHERE $whereClause
    ";
    $totalResult = fetchOne($countSql, $params);
    $total = $totalResult['total'];
    
    // Lấy danh sách sản phẩm
    $sql = "
        SELECT 
            p.id,
            p.product_code,
            p.name,
            p.slug,
            p.price,
            p.sale_price,
            p.volume,
            p.concentration,
            p.gender,
            p.duration,
            p.sillage,
            p.description,
            p.main_image,
            p.is_featured,
            p.stock_quantity,
            p.created_at,
            b.name as brand_name,
            b.slug as brand_slug,
            c.name as category_name,
            c.slug as category_slug
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE $whereClause
        ORDER BY $orderBy
        LIMIT $limit OFFSET $offset
    ";
    
    $products = fetchAll($sql, $params);
    
    // Format dữ liệu
    $formattedProducts = [];
    foreach ($products as $product) {
        $formattedProducts[] = [
            'id' => $product['id'],
            'product_code' => $product['product_code'],
            'name' => $product['name'],
            'slug' => $product['slug'],
            'price' => number_format($product['price'], 0, ',', '.'),
            'sale_price' => $product['sale_price'] ? number_format($product['sale_price'], 0, ',', '.') : null,
            'volume' => $product['volume'],
            'concentration' => $product['concentration'],
            'gender' => $product['gender'],
            'duration' => $product['duration'],
            'sillage' => $product['sillage'],
            'description' => $product['description'],
            'main_image' => $product['main_image'],
            'is_featured' => (bool)$product['is_featured'],
            'stock_quantity' => $product['stock_quantity'],
            'brand' => [
                'name' => $product['brand_name'],
                'slug' => $product['brand_slug']
            ],
            'category' => [
                'name' => $product['category_name'],
                'slug' => $product['category_slug']
            ],
            'created_at' => $product['created_at']
        ];
    }
    
    // Tính toán pagination
    $totalPages = ceil($total / $limit);
    $hasNext = $page < $totalPages;
    $hasPrev = $page > 1;
    
    // Response
    $response = [
        'success' => true,
        'data' => [
            'products' => $formattedProducts,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $total,
                'items_per_page' => $limit,
                'has_next' => $hasNext,
                'has_prev' => $hasPrev
            ],
            'filters' => [
                'category' => $category,
                'brand' => $brand,
                'gender' => $gender,
                'featured' => $featured,
                'search' => $search,
                'sort' => $sort
            ]
        ]
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
