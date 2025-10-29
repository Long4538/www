<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    header('Location: ../Index.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Xóa ảnh trước
    $pdo->prepare("DELETE FROM product_images WHERE product_id = :id")->execute([':id' => $id]);
    // Xóa sản phẩm
    $pdo->prepare("DELETE FROM products WHERE id = :id")->execute([':id' => $id]);
}

header('Location: quanly_sanpham.php');
exit;
?>
