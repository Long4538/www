<div class="product-detail">
    <?php if ($sp) { ?>
        <div class="product-detail-container">
            <!-- Cột trái: Hình ảnh -->
            <div class="product-detail-left">
                <img src="../view/images/products/<?= $sp['image_main'] ?>" alt="<?= $sp['name'] ?>" class="product-main-img">
            </div>

            <!-- Cột phải: Thông tin -->
            <div class="product-detail-right">
               <h2 style="font-size: 34px;" class="product-name"><?= $sp['name'] ?></h2>
                <div class="product-price">
                    <span class="price-sale"><?= number_format($sp['price']) ?>đ</span>
                </div>
                    <div class="product-discount">
                    <?= nl2br($sp['discount']) ?>đ
                </div>


                <div class="product-desc">
                    <?= nl2br($sp['description']) ?>
                </div>

            
                <ul class="product-policy">
                    <li>✅ Cam kết bảo hành chính hãng 1 năm</li>
                    <li>🔁 Hoàn trả hàng trong 7 ngày</li>
                    <li>🚚 Kiểm tra hàng rồi mới thanh toán</li>
                </ul>

                <div class="color-options">
                    <span>Màu sắc:</span>
                    <div class="color-dot red"></div>
                    <div class="color-dot black"></div>
                    <div class="color-dot blue"></div>
                    <div class="color-dot white"></div>
                </div>

                <div class="size-options">
                    <span>Size:</span>
                    <button>S</button>
                    <button>M</button>
                    <button>L</button>
                    <button>XL</button>
                </div>

                <div class="product-buttons">
                    <input type="number" value="1" min="1" class="qty-input">
                    <button class="btn-cart">Thêm vào giỏ hàng</button>
                    <button class="btn-buy">Mua ngay</button>
                </div>

                <div class="product-meta">
                    <p><strong>Số lượng:</strong> <?= $sp['quantity'] ?? 'Không rõ' ?></p>
                    <p><strong>Mã sản phẩm:</strong> <?= $sp['product_code'] ?? 'N/A' ?></p>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p>Không tìm thấy sản phẩm!</p>
    <?php } ?>
</div>

<!-- ====================== BÌNH LUẬN ====================== -->
<?php
// NHẬN BIẾN TỪ CONTROLLER - SỬA CÁCH NÀY
global $sp, $comments, $error;

// Đảm bảo các biến này tồn tại
$comments = $comments ?? [];
$error = $error ?? '';

?>

<!-- PHẦN CHI TIẾT SẢN PHẨM -->
<div class="product-detail">
    <!-- ... your existing product detail code ... -->
</div>

<div class="comment-section" style="margin-top: 30px;">
    <h3 style="color: #a00;">Bình luận:</h3>

    <?php if (isset($_SESSION['user'])) { ?>
        <form action="" method="POST" class="comment-form">
            <div style="margin-bottom: 10px;">
                <label>Đánh giá:</label>
                <select name="rating" style="padding: 4px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="5">5 ⭐</option>
                    <option value="4">4 ⭐</option>
                    <option value="3">3 ⭐</option>
                    <option value="2">2 ⭐</option>
                    <option value="1">1 ⭐</option>
                </select>
            </div>
            <textarea name="content" placeholder="Nhập bình luận của bạn..." required
                style="width:100%;height:80px;padding:8px;border-radius:4px;border:1px solid #ccc;"></textarea>
            <button type="submit"
                style="margin-top:8px;background:#a00;color:white;padding:6px 12px;border:none;border-radius:4px;cursor:pointer;">
                Gửi bình luận
            </button>
        </form>
    <?php } else { ?>
        <div style="color:red;border:1px solid #ddd;padding:10px;margin-top:5px;">
            Bạn cần <a href="index.php?act=login" style="color:blue;">đăng nhập</a> để có thể bình luận ❌
        </div>
    <?php } ?>

    <div class="comment-list" style="margin-top:15px;">
        <?php if (!empty($comments)) { ?>
            <h4>Đánh giá từ khách hàng:</h4>
            <?php foreach ($comments as $c) { ?>
                <div style="border-bottom:1px solid #eee;padding:10px 0;">
                    <strong><?= htmlspecialchars($c['username'] ?? 'Người dùng') ?></strong>
                    <span style="color:orange;">(<?= $c['rating'] ?? 5 ?>/5 ⭐)</span>
                    <p style="margin:5px 0;"><?= nl2br(htmlspecialchars($c['content'] ?? '')) ?></p>
                    <small style="color:#666;"><?= date('d/m/Y H:i', strtotime($c['created_at'] ?? 'now')) ?></small>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Chưa có bình luận nào.</p>
        <?php } ?>
    </div>
</div>


<!-- Danh sách sản phẩm-->
<div class="section-container">
    <div class="top-products-section">
        <h2 class="top-products-title">Danh sách sản phẩm liên quan</h2>

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