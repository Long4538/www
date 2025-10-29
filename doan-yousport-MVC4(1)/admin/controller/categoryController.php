<?php
include_once '../../config/database.php';
include_once '../model/categoryModel.php';

$database = new Database();
$db = $database->getConnection();

$categoryModel = new CategoryModel($db);
$categories = $categoryModel->getAllCategories();

include '../view/categoryList.php';
?>
