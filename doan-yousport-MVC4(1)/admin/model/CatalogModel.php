<?php
function getAllCatalogs() {
    $sql = "SELECT * FROM danhmuc ORDER BY id DESC";
    return pdo_query($sql);
}

function insertCatalog($ten_danhmuc) {
    $sql = "INSERT INTO danhmuc (ten_danhmuc) VALUES (?)";
    pdo_execute($sql, $ten_danhmuc);
}

function deleteCatalog($id) {
    $sql = "DELETE FROM danhmuc WHERE id = ?";
    pdo_execute($sql, $id);
}

function getCatalogById($id) {
    $sql = "SELECT * FROM danhmuc WHERE id = ?";
    return pdo_query_one($sql, $id);
}

function updateCatalog($id, $ten_danhmuc) {
    $sql = "UPDATE danhmuc SET ten_danhmuc = ? WHERE id = ?";
    pdo_execute($sql, $ten_danhmuc, $id);
}
?>
