<?php
// Lấy tất cả bình luận (kèm tên người dùng và tên sản phẩm)
function get_all_binhluan() {
    $sql = "SELECT r.review_id, r.comment, r.rating, r.created_at,
                   u.full_name AS ten_nguoidung,
                   p.name AS ten_sanpham
            FROM reviews r
            LEFT JOIN users u ON r.user_id = u.user_id
            LEFT JOIN products p ON r.product_id = p.product_id
            ORDER BY r.review_id DESC";
    return pdo_query($sql);
}

// Xóa bình luận theo ID
function delete_binhluan($id) {
    $sql = 'DELETE FROM reviews WHERE review_id = ?';
    pdo_execute($sql, $id);
}
?>
