<!-- Banner Slider -->
 <div class="banner-slider">
     <div class="slides">
         <img src="../view/images/banner/ads_1.jpg" class="slide active" alt="Banner 1">
         <img src="../view/images/banner/ads_2.jpg" class="slide" alt="Banner 2">
         <img src="../view/images/banner/ads_3.jpg" class="slide" alt="Banner 3">
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

 <!-- Service -->
 <table class="service-table">
     <tr>
         <td class="service-cell">
             <i class="ti-truck service-icon"></i>
             <h4 class="service-title">Miễn phí giao hàng</h4>
             <p class="service-desc">Toàn quốc</p>
         </td>
         <td class="service-cell">
             <i class="ti-wallet service-icon"></i>
             <h4 class="service-title">Hoàn tiền</h4>
             <p class="service-desc">Hoàn tiền trong 30 ngày</p>
         </td>
         <td class="service-cell">
             <i class="ti-headphone-alt service-icon"></i>
             <h4 class="service-title">Hỗ trợ online 24/7</h4>
             <p class="service-desc">Hỗ trợ khách hàng</p>
         </td>
         <td class="service-cell">
             <i class="ti-credit-card service-icon"></i>
             <h4 class="service-title">Bảo mật thanh toán</h4>
             <p class="service-desc">Thanh toán an toàn</p>
         </td>
     </tr>
 </table>

 <!-- TOP 10 sản phẩm -->
 <div class="section-container">
     <div class="top-products-section">
         <h2 class="top-products-title">Top 4 sản phẩm yêu thích nhất</h2>

         <div class="top-products-list">
             <?php
                require_once "../model/ProductModel.php";
                $productModel = new ProductModel();
                $list = $productModel->getProductsByCatalog(2, 4);
                ?>

             <?php if (!empty($list)) { ?>
                 <?php foreach ($list as $sp) { ?>
                     <div class="top-product-card">
                         <img src="../view/images/products/<?= $sp['image_main'] ?>" alt="<?= $sp['name'] ?>" class="top-product-img">
                         <h3 class="top-product-name"><?= $sp['name'] ?></h3>
                         <div class="top-product-price">
                             <span class="price-sale"><?= number_format($sp['price']) ?>đ</span>
                             <div class="product-discount">
                                 <?= nl2br($sp['discount']) ?>đ
                             </div>

                         </div>
                         <a href="index.php?act=chitietsanpham&id=<?= $sp['product_id'] ?>" class="btn-top-detail">Xem chi tiết</a>
                     </div>
                 <?php } ?>
             <?php } else { ?>
                 <p>Không có sản phẩm nào trong danh mục này.</p>
             <?php } ?>
         </div>
     </div>



     <!-- Danh mục thẻ -->
     <?php
        require_once "../model/ProductModel.php";
        $productModel = new ProductModel();

        // Lấy 3 sản phẩm theo catalog id (ví dụ: 5 là catalog "Đồ thể thao")
        $products = $productModel->getProductsByCatalog(8, 3);
        ?>

     <div class="section-container">
         <div class="category-container">
             <?php if (!empty($products)) { ?>

                 <!-- Sản phẩm đầu tiên (to bên trái) -->
                 <?php $first = $products[0]; ?>
                 <div class="category-left">
                     <h2 class="category-title"><?= htmlspecialchars($first['name']) ?></h2>
                     <ul class="team-list">
                         <li><strong>Giá:</strong> <?= number_format($first['price']) ?>đ</li>
                         <li><strong>Loại:</strong> <?= htmlspecialchars($first['catalog_name'] ?? '') ?></li>
                         <li><strong>Mô tả:</strong> <?= htmlspecialchars(mb_substr($first['description'], 0, 60)) ?>...</li>
                     </ul>
                     <a href="index.php?act=chitietsanpham&id=<?= $first['product_id'] ?>" class="more-link">Xem thêm...</a>
                     <img src="../view/images/products/<?= htmlspecialchars($first['image_main']) ?>"
                         alt="<?= htmlspecialchars($first['name']) ?>" class="category-img" style="float:right;top:5%;">
                 </div>

                 <!-- Hai sản phẩm còn lại (bên phải) -->
                 <div class="category-right">
                     <?php for ($i = 1; $i < count($products); $i++) {
                            $sp = $products[$i];
                            $bgClass = ($i == 1) ? "bg-blue" : "bg-pink"; // xen màu
                        ?>
                         <div class="category-box <?= $bgClass ?>">
                             <div class="category-info">
                                 <h3 class="category-subtitle"><?= htmlspecialchars($sp['name']) ?></h3>
                                 <p class="category-desc">
                                     <?= htmlspecialchars(mb_substr($sp['description'], 0, 80)) ?>...
                                 </p>
                                 <a href="index.php?act=chitietsanpham&id=<?= $sp['product_id'] ?>" class="more-link">Xem thêm...</a>
                             </div>
                             <img src="../view/images/products/<?= htmlspecialchars($sp['image_main']) ?>"
                                 alt="<?= htmlspecialchars($sp['name']) ?>" class="category-img">
                         </div>
                     <?php } ?>
                 </div>

             <?php } else { ?>
                 <p>Không có sản phẩm nào trong danh mục này.</p>
             <?php } ?>
         </div>
     </div>


     <!-- Danh sách sản phẩm-->
     <div class="section-container">
         <div class="top-products-section">
             <h2 class="top-products-title">Danh sách sản phẩm</h2>

             <div class="top-products-list">
                 <?php
                    require_once "../model/ProductModel.php";
                    $productModel = new ProductModel();
                    $list = $productModel->getProductsByCatalog(7, 8);
                    ?>

                 <?php if (!empty($list)) { ?>
                     <?php foreach ($list as $sp) { ?>
                         <div class="top-product-card">
                             <img src="../view/images/products/<?= $sp['image_main'] ?>" alt="<?= $sp['name'] ?>" class="top-product-img">
                             <h3 class="top-product-name"><?= $sp['name'] ?></h3>
                             <div class="top-product-price">
                                 <span class="price-sale"><?= number_format($sp['price']) ?>đ</span>
                                 <div class="product-discount">
                                     <?= nl2br($sp['discount']) ?>đ
                                 </div>
                             </div>
                             <a href="index.php?act=chitietsanpham&id=<?= $sp['product_id'] ?>" class="btn-top-detail">Xem chi tiết</a>
                         </div>
                     <?php } ?>
                 <?php } else { ?>
                     <p>Không có sản phẩm nào trong danh mục này.</p>
                 <?php } ?>
             </div>
         </div>

         <!-- Thêm các sản phẩm khác tương tự -->
     </div>

 </div>

 <!-- KHU VỰC SẢN PHẨM -->
 <div class="section-container center-content">

     <section class="new-products-ads">
         <div class="ads-list">
             <a href="#" class="ads-item">
                 <img src="../view/images/products/ads-product-1.jpg" alt="Giày Tennis" class="ads-img">
             </a>

             <a href="#" class="ads-item">
                 <img src="../view/images/products/ads-product-2.jpg" alt="Giày Tây dành cho nam" class="ads-img">
             </a>

             <a href="#" class="ads-item">
                 <img src="../view/images/products/ads-product-3.jpg" alt="Gấu thủ thân Sandal" class="ads-img">
             </a>
         </div>
     </section>

 </div>
