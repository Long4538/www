<?php
// Lấy tổng quan dữ liệu
function get_tongquan() {
    $sql = "
        SELECT
            (SELECT COUNT(*) FROM orders) AS tong_donhang,
            (SELECT SUM(price * quantity) FROM orders) AS tong_doanhthu,
            (SELECT COUNT(*) FROM users) AS tong_thanhvien,
            (SELECT COUNT(*) FROM products) AS tong_sanpham
    ";
    return pdo_query_one($sql);
}

// Thống kê trạng thái đơn hàng
function get_tyle_donhang() {
    $sql = "
        SELECT 
            status,
            COUNT(*) AS so_luong
        FROM transactions
        GROUP BY status
    ";
    return pdo_query($sql);
}

// Lấy 5 đơn hàng mới nhất
function get_5_donhang_moinhat() {
    $sql = "
        SELECT 
            o.order_id,
            u.full_name AS ten_khach,
            SUM(o.price * o.quantity) AS tong_tien,
            t.status,
            t.created_at
        FROM orders o
        JOIN transactions t ON o.transaction_id = t.transaction_id
        JOIN users u ON t.user_id = u.user_id
        GROUP BY o.transaction_id
        ORDER BY t.created_at DESC
        LIMIT 5
    ";
    return pdo_query($sql);
}
?>
