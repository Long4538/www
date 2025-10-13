<?php
/**
 * API LẤY THÔNG TIN SẢN PHẨM
 * 
 * Endpoint: /Webdior/api/get-product.php?id={product_id}
 * Method: GET
 * Response: JSON
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database config
require_once '../config/database.php';

try {
    // Kiểm tra tham số ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('Thiếu tham số ID sản phẩm');
    }
    
    $productId = (int)$_GET['id'];
    
    if ($productId <= 0) {
        throw new Exception('ID sản phẩm không hợp lệ');
    }
    
    // Lấy thông tin sản phẩm
    $product = fetchOne("
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
        WHERE p.id = ? AND p.is_active = 1
    ", [$productId]);
    
    if (!$product) {
        throw new Exception('Không tìm thấy sản phẩm');
    }
    
    // Lấy hình ảnh sản phẩm
    $images = fetchAll("
        SELECT image_path, alt_text, is_main, sort_order
        FROM product_images
        WHERE product_id = ?
        ORDER BY is_main DESC, sort_order ASC
    ", [$productId]);
    
    // Nếu không có hình ảnh, sử dụng hình chính
    if (empty($images)) {
        $images = [
            [
                'image_path' => $product['main_image'],
                'alt_text' => $product['name'],
                'is_main' => 1,
                'sort_order' => 0
            ]
        ];
    }
    
    // Không lấy dữ liệu hương thơm
    $notes = [
        'top' => [],
        'middle' => [],
        'base' => []
    ];
    
    // Lấy sản phẩm liên quan
    $relatedProducts = fetchAll("
        SELECT 
            p.id,
            p.name,
            p.slug,
            p.price,
            p.main_image,
            p.description
        FROM products p
        INNER JOIN related_products rp ON p.id = rp.related_product_id
        WHERE rp.product_id = ? AND p.is_active = 1
        ORDER BY rp.sort_order
        LIMIT 4
    ", [$productId]);
    
    // Chuẩn bị response
    $response = [
        'success' => true,
        'data' => [
            'product' => [
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
            ],
            'images' => $images,
            'fragrance_notes' => $notes,
            'related_products' => $relatedProducts
        ]
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
