<?php
require_once "../model/ProductModel.php";
$productModel = new ProductModel();
$list = $productModel->getProductsByCatalog(8, 8);
?>

<!-- Gọi file CSS chính -->
<link rel="stylesheet" href="../view/css/style.css">


<!-- Banner Slider -->
<div class="banner-slider">
    <div class="slides">
        <img src="../view/images/banner/ads_accessory-1.webp" class="slide active" alt="Banner 1">
        <img src="../view/images/banner/ads_accessory-2.jpg" class="slide" alt="Banner 2">
        <img src="../view/images/banner/ads_accessory-3.png" class="slide" alt="Banner 3">
    </div>

    <!-- Nút điều hướng -->
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>

    <!-- Chấm chỉ báo -->
    <div class="dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</div>


<div class="related-section">
    <h2 class="related-title">ĐỒ THỂ THAO BÓNG RỔ</h2>

    <div class="related-grid">
        <?php if (!empty($list)) { ?>
            <?php foreach ($list as $sp) { ?>
                <div class="related-card">
                    <img src="../view/images/products/<?= $sp['image_main'] ?>" alt="<?= $sp['name'] ?>">
                    <div class="product-name"><?= $sp['name'] ?></div>
                    <div class="product-price">
                        <span class="new-price"><?= number_format($sp['price']) ?>đ</span>
                    </div>
                    <div class="product-discount">
                        <?= nl2br($sp['discount']) ?>đ
                    </div>
                    <a href="index.php?act=chitietsanpham&id=<?= $sp['product_id'] ?>" class="btn-view">Xem chi tiết</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Không có sản phẩm nào trong danh mục này.</p>
        <?php } ?>
    </div>
</div>