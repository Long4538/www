<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../model/ProductModel.php";
$productModel = new ProductModel();

$id = $_GET['id'] ?? 0;

// ✅ Nếu POST => thêm bình luận
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    if (!empty($_SESSION['user'])) {
        $user_id = $_SESSION['user']['user_id'];
        $rating = (int)($_POST['rating'] ?? 5);
        $comment = trim($_POST['content']);

        if ($comment !== '') {
            $productModel->addReview($id, $user_id, $rating, $comment);
        }
    }
}

// ✅ Luôn tải lại bình luận sau khi thêm
$product = $productModel->getProductById($id);
$comments = $productModel->getReviewsByProduct($id);
?>



<div class="product-detail">
    <?php if ($sp): ?>
        <div class="product-detail-container">
            <!-- Cột trái: Hình ảnh -->
            <div class="product-detail-left">
                <img src="../view/images/products/<?= htmlspecialchars($sp['image_main']) ?>"
                    alt="<?= htmlspecialchars($sp['name']) ?>"
                    class="product-main-img">
            </div>

            <!-- Cột phải: Thông tin -->
            <div class="product-detail-right">
                <h2 class="product-name" style="font-size: 34px;">
                    <?= htmlspecialchars($sp['name']) ?>
                </h2>

                <div class="product-price">
                    <span class="price-sale"><?= number_format($sp['price']) ?>đ</span>
                </div>

                <div class="product-discount">
                    <?= nl2br(htmlspecialchars($sp['discount'])) ?>
                </div>

                <div class="product-desc">
                    <?= nl2br(htmlspecialchars($sp['description'])) ?>
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

                <!-- ✅ Nút thêm giỏ hàng và mua ngay -->
                <div class="product-buttons">
                    <!-- FORM Thêm vào giỏ hàng -->
                    <form action="./CartController.php?action=add" method="POST" style="display:inline-block;">

                        <input type="hidden" name="id" value="<?= $sp['product_id'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($sp['name']) ?>">
                        <input type="hidden" name="price" value="<?= $sp['price'] ?>">
                        <input type="hidden" name="image" value="<?= htmlspecialchars($sp['image_main']) ?>">
                        <input type="number" name="quantity" value="1" min="1" class="qty-input" style="width:60px;">
                        <button type="submit" class="btn-cart"
                            style="background:#ff3399;color:white;padding:8px 18px;border:none;border-radius:5px;cursor:pointer;">
                            🛒 Thêm vào giỏ hàng
                        </button>
                    </form>

                    <!-- FORM Mua ngay -->
                    <form action="../controller/CartController.php?action=buynow" method="POST" style="display:inline-block;">

                        <input type="hidden" name="id" value="<?= $sp['product_id'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($sp['name']) ?>">
                        <input type="hidden" name="price" value="<?= $sp['price'] ?>">
                        <input type="hidden" name="image" value="<?= htmlspecialchars($sp['image_main']) ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buy"
                            style="background:red;color:white;padding:8px 18px;border:none;border-radius:5px;cursor:pointer;">
                            Mua ngay
                        </button>
                    </form>
                </div>

                <div class="product-meta">
                    <p><strong>Số lượng:</strong> <?= htmlspecialchars($sp['quantity'] ?? 'Không rõ') ?></p>
                    <p><strong>Mã sản phẩm:</strong> <?= htmlspecialchars($sp['product_code'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Không tìm thấy sản phẩm!</p>
    <?php endif; ?>
</div>

<!-- ====================== BÌNH LUẬN ====================== -->
<?php
global $sp, $comments, $error;
$comments = $comments ?? [];
$error = $error ?? '';  // Giữ nguyên nếu bạn dùng, nhưng nên dùng session thay thế

// ✅ THÊM ĐÂY: Lấy error/success từ session (từ controller)
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Đảm bảo session active
}
$error_msg = $_SESSION['error'] ?? null;
$success_msg = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);  // Clear sau khi dùng để tránh lặp
?>
<div class="comment-section" style="margin-top: 30px;">
    <h3 style="color: #a00;">Bình luận:</h3>

    <?php if (!empty($_SESSION['user'])): ?>
        <form action="" method="POST" class="comment-form">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($id) ?>">
            <div style="margin-bottom: 10px;">
                <label>Đánh giá:</label>
                <select name="rating" style="padding:4px;border-radius:4px;border:1px solid #ccc;">
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

        <!-- ✅ THÊM ĐÂY: Hiển thị thông báo error/success -->
        <?php if ($error_msg): ?>
            <div class="error" style="color: red; background: #ffe6e6; border: 1px solid red; padding: 10px; margin: 10px 0; border-radius: 4px;">
                <?= htmlspecialchars($error_msg) ?> ❌
            </div>
        <?php endif; ?>

        <?php if ($success_msg): ?>
            <div class="success" style="color: green; background: #e6ffe6; border: 1px solid green; padding: 10px; margin: 10px 0; border-radius: 4px;">
                <?= htmlspecialchars($success_msg) ?> ✅
            </div>
        <?php endif; ?>

    <?php else: ?>
        <?php
        $currentUrl = "index.php?act=chitietsanpham&id=" . urlencode($sp['product_id']);
        $loginUrl = "index.php?act=login&redirect=" . urlencode($currentUrl);
        ?>
        <div style="color:red;border:1px solid #ddd;padding:10px;margin-top:5px;">
            Bạn cần <a href="<?= $loginUrl ?>" style="color:blue;">đăng nhập</a> để có thể bình luận ❌
        </div>
    <?php endif; ?>

   <div class="comment-list" style="margin-top:25px;">
    <?php if (!empty($comments)): ?>
        <h4 style="font-size:20px; font-weight:600; color:#222; margin-bottom:15px;">
            💬 Đánh giá từ khách hàng:
        </h4>
        <?php foreach ($comments as $c): ?>
            <div style="
                border: 1px solid #e5e5e5;
                border-radius: 10px;
                padding: 10px 15px;
                margin-bottom: 12px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                text-align: left;
            ">
                <div style="font-weight:600; color:#333;">
                    <?= htmlspecialchars($c['username'] ?? 'Người dùng') ?>
                    <small style="color:#888; font-weight:400;">
                        <?= date('d/m/Y H:i', strtotime($c['created_at'] ?? 'now')) ?>
                    </small>
                </div>
                <div style="color:#f39c12; margin:4px 0 6px;">
                    ⭐ <?= htmlspecialchars($c['rating'] ?? 5) ?>/5
                </div>
                <div style="color:#444; line-height:1.5;">
                    <?= nl2br(htmlspecialchars($c['content'] ?? '')) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color:#666;">Chưa có bình luận nào.</p>
    <?php endif; ?>
</div>

</div>

<!-- ====================== SẢN PHẨM LIÊN QUAN ====================== -->
<div class="section-container">
    <div class="top-products-section">
        <h2 class="top-products-title">Danh sách sản phẩm liên quan</h2>

        <div class="top-products-list">
            <?php
            $list = $productModel->getProductsByCatalog(7, 8);
            ?>

            <?php if (!empty($list)): ?>
                <?php foreach ($list as $sp): ?>
                    <div class="top-product-card">
                        <img src="../view/images/products/<?= htmlspecialchars($sp['image_main']) ?>"
                            alt="<?= htmlspecialchars($sp['name']) ?>"
                            class="top-product-img">
                        <h3 class="top-product-name"><?= htmlspecialchars($sp['name']) ?></h3>
                        <div class="top-product-price">
                            <span class="price-sale"><?= number_format($sp['price']) ?>đ</span>
                            <div class="product-discount"><?= nl2br(htmlspecialchars($sp['discount'])) ?></div>
                        </div>
                        <a href="index.php?act=chitietsanpham&id=<?= $sp['product_id'] ?>"
                            class="btn-top-detail">Xem chi tiết</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </div>
</div>