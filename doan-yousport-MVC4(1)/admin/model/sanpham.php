<?php
// Lấy tất cả sản phẩm
function get_all_sanpham() {
    $sql = "SELECT p.product_id AS id, 
                   p.name AS ten_sanpham, 
                   p.price AS gia, 
                   p.discount AS giam_gia, 
                   p.image_main AS hinh, 
                   c.name AS ten_danhmuc
            FROM products p
            LEFT JOIN catalogs c ON p.catalog_id = c.catalog_id
            ORDER BY p.product_id DESC";
    return pdo_query($sql);
}

// 🔹 LẤY SẢN PHẨM THEO ID (để sửa)
function get_sanpham_by_id($id) {
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $result = pdo_query_one($sql, $id);
    return $result;
}

// 🔹 THÊM SẢN PHẨM MỚI
function insert_sanpham($ten, $gia, $giamgia, $hinh, $mota, $catalog_id) {
    $sql = "INSERT INTO products (name, price, discount, image_main, description, catalog_id)
            VALUES (?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $ten, $gia, $giamgia, $hinh, $mota, $catalog_id);
}

// 🔹 CẬP NHẬT SẢN PHẨM
function update_sanpham($id, $ten, $gia, $giamgia, $hinh, $mota, $catalog_id) {
    $sql = "UPDATE products 
            SET name=?, price=?, discount=?, image_main=?, description=?, catalog_id=?
            WHERE product_id=?";
    pdo_execute($sql, $ten, $gia, $giamgia, $hinh, $mota, $catalog_id, $id);
}

// 🔹 XÓA SẢN PHẨM
function delete_sanpham($id) {
    $sql = "DELETE FROM products WHERE product_id=?";
    pdo_execute($sql, $id);
}
?>
