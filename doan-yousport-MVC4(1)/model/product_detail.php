<?php
session_start();
require_once "../model/ProductModel.php";
$productModel = new ProductModel();

$id = $_GET['id'] ?? 0;
$product = $productModel->getProductById($id);

if (!$product) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
?>

<link rel="stylesheet" href="../view/css/style.css">

<div class="product-detail">
    <div class="image">
        <img src="../view/images/products/<?= $product['image'] ?>" width="400">
    </div>
    <div class="info">
        <h2><?= $product['name'] ?></h2>
        <p style="font-size:22px; color:red; font-weight:bold;">
            <?= number_format($product['price']) ?>đ
        </p>
        <p><?= $product['description'] ?></p>

        <form method="POST" action="../controller/CartController.php?action=add">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <input type="hidden" name="name" value="<?= $product['name'] ?>">
            <input type="hidden" name="price" value="<?= $product['price'] ?>">
            <input type="hidden" name="image" value="<?= $product['image'] ?>">

            <label>Màu sắc:</label>
            <select name="color">
                <option value="Nâu">Nâu</option>
                <option value="Đen">Đen</option>
                <option value="Trắng">Trắng</option>
                <option value="Xanh">Xanh</option>
            </select><br><br>

            <label>Size:</label>
            <select name="size">
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select><br><br>

            <label>Số lượng:</label>
            <input type="number" name="quantity" value="1" min="1" style="width:60px;"><br><br>

            <button type="submit" class="btn-order">🛒 Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>
