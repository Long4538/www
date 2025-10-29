<?php
// ================== TỔNG QUAN ==================
function get_tongquan() {
    $sql = "
        SELECT 
            (SELECT COUNT(*) FROM transactions) AS tong_donhang,
            (SELECT SUM(price * quantity) FROM orders) AS tong_doanhthu,
            (SELECT COUNT(*) FROM users) AS tong_taikhoan,
            (SELECT COUNT(*) FROM products) AS tong_sanpham
    ";
    return pdo_query_one($sql);
}

// ================== BIỂU ĐỒ TRẠNG THÁI ==================
function get_tyle_donhang() {
    $sql = "
        SELECT
            SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) AS cho_xuly,
            SUM(CASE WHEN status='paid' THEN 1 ELSE 0 END) AS da_thanhtoan, 
            SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) AS da_huy
        FROM transactions
        WHERE status IN ('pending', 'paid', 'cancelled') -- <-- THÊM DÒNG NÀY
    ";
    // Lưu ý: Nếu bạn dùng cả 'completed', hãy thêm nó vào IN(...)
    // WHERE status IN ('pending', 'paid', 'completed', 'cancelled')
    
    return pdo_query_one($sql);
}

// ================== 5 ĐƠN HÀNG MỚI NHẤT ==================
function get_5_donhang_moinhat() {
    $sql = "
        SELECT t.transaction_id AS order_id, u.full_name AS ten_khach,
               SUM(o.price * o.quantity) AS tong_tien, t.status, t.created_at
        FROM transactions t
        JOIN orders o ON t.transaction_id = o.transaction_id
        LEFT JOIN users u ON t.user_id = u.user_id
        GROUP BY t.transaction_id
        ORDER BY t.created_at DESC
        LIMIT 5
    ";
    return pdo_query($sql);
}

// ================== THỐNG KÊ DOANH THU & DANH MỤC ==================
// ⚙️ Nếu bạn đang dùng phần "Thống kê" riêng ở index.php (case 'thongke')
function get_thongke_tong() {
    $sql = "
        SELECT 
            COUNT(DISTINCT t.transaction_id) AS tong_donhang,
            SUM(o.price * o.quantity) AS tong_doanhthu
        FROM transactions t
        JOIN orders o ON t.transaction_id = o.transaction_id
    ";
    return pdo_query_one($sql);
}

function get_thongke_theodanhmuc() {
    $sql = "
        SELECT c.name AS ten_danhmuc,
               SUM(o.quantity * o.price) AS doanhthu,
               COUNT(DISTINCT o.product_id) AS so_sanpham
        FROM orders o
        JOIN products p ON o.product_id = p.product_id
        JOIN catalogs c ON p.catalog_id = c.catalog_id
        GROUP BY c.catalog_id
        ORDER BY doanhthu DESC
    ";
    return pdo_query($sql);
}


?>
