<?php
include_once "model/CatalogModel.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        if (isset($_POST['add'])) {
            $ten_danhmuc = $_POST['ten_danhmuc'];
            insertCatalog($ten_danhmuc);
            $thongbao = "Thêm danh mục thành công!";
        }
        include "view/catalog_add.php";
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $dm = getCatalogById($_GET['id']);
        }
        include "view/catalog_edit.php";
        break;

    case 'update':
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $ten_danhmuc = $_POST['ten_danhmuc'];
            updateCatalog($id, $ten_danhmuc);
        }
        header("Location: index.php?act=danhsach_danhmuc");
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            deleteCatalog($_GET['id']);
        }
        header("Location: index.php?act=danhsach_danhmuc");
        break;

    default: // danh sách
        $list = getAllCatalogs();
        include "view/danhsach_danhmuc.php";
        break;
}
