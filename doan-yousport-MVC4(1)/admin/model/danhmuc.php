<?php
// Lấy danh sách tất cả danh mục
function get_all_danhmuc() {
    $sql = "SELECT catalog_id AS id, name AS ten_danhmuc, description AS mota FROM catalogs ORDER BY catalog_id ASC";
    return pdo_query($sql);
}

// Thêm danh mục mới
function insert_danhmuc($ten_danhmuc, $mota = null) {
    $sql = "INSERT INTO catalogs (name, description) VALUES ('$ten_danhmuc', '$mota')";
    pdo_execute($sql);
}

// Lấy thông tin danh mục theo ID
function get_danhmuc_by_id($id) {
    $sql = "SELECT * FROM catalogs WHERE catalog_id = $id";
    $result = pdo_query($sql);
    return $result ? $result[0] : null;
}

// Cập nhật danh mục
function update_danhmuc($id, $ten_danhmuc, $mota = null) {
    $sql = "UPDATE catalogs SET name = '$ten_danhmuc', description = '$mota' WHERE catalog_id = $id";
    pdo_execute($sql);
}

// Xóa danh mục
function delete_danhmuc($id) {
    $sql = "DELETE FROM catalogs WHERE catalog_id = $id";
    pdo_execute($sql);
}
?>
