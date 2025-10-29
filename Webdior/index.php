<?php $page_title = 'Trang chủ | Webdior'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php 
include 'includes/head.php'; 
require_once 'config/database.php';
require_once 'config/security.php';

// Lấy sản phẩm nổi bật từ database
$featuredProducts = [];
try {
    $featuredProducts = fetchAll("
        SELECT p.id, p.name, p.price, p.main_image, p.product_code
        FROM products p
        WHERE p.is_featured = 1 AND p.is_active = 1
        ORDER BY p.created_at DESC
        LIMIT 8
    ");
} catch (Exception $e) {
    // Fallback về dữ liệu mẫu nếu database lỗi
    $featuredProducts = [];
}
?>
</head>
<body>
    <!-- Header / Thanh điều hướng (Navbar - Bootstrap) -->
    <?php include 'includes/header.php';?>

    <main>
        <!-- Khu vực Hero (giới thiệu đầu trang) -->
        <section class="hero py-5 border-bottom">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-semibold" style="font-family:'Playfair Display',serif">Smell good – Feel good</h1>
                        <p class="text-secondary mb-3">Khám phá bộ sưu tập nước hoa chính hãng, tuyển chọn tinh tế.</p>
                        <div class="d-flex gap-2">
                            <a class="btn btn-dark" href="#noi-bat">Mua ngay</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-3 rounded-4 hero-card">
                            <img src="/Webdior/images/gioithieu/hero.jpg" alt="Hero Bottle">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Danh mục -->
        <!-- <section id="bo-suu-tap" class="py-4">
            <div class="container">
                <h2 class="h3 mb-3" style="font-family:'Playfair Display',serif">Danh mục</h2>
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#nuoc-hoa-nam">Nước hoa nam</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#nuoc-hoa-nu">Nước hoa nữ</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#unisex">Unisex</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#body-spray">Body spray</a></div>
                </div>
            </div>
        </section> -->

        <!-- Anchor sections cho dropdown navigation -->
        <div id="nuoc-hoa-nam" style="padding-top: 80px; margin-top: -80px;"></div>
        <div id="nuoc-hoa-nu" style="padding-top: 80px; margin-top: -80px;"></div>
        <div id="unisex" style="padding-top: 80px; margin-top: -80px;"></div>
        <div id="body-spray" style="padding-top: 80px; margin-top: -80px;"></div>
        <div id="tin-tuc" style="padding-top: 80px; margin-top: -80px;"></div>

        <!-- Sản phẩm nổi bật -->
        <section id="noi-bat" class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h2 class="h3 m-0" style="font-family:'Playfair Display',serif">Sản phẩm nổi bật</h2>
                    <a class="text-secondary" href="#tat-ca">Xem tất cả</a>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                    <?php if (!empty($featuredProducts)): ?>
                        <?php foreach ($featuredProducts as $product): ?>
                        <div class="col">
                            <article class="card bg-transparent border-0 product-card p-2">
                                <a href="/Webdior/page/san-pham.php?id=<?= $product['id'] ?>" class="text-decoration-none">
                                    <?php if ($product['main_image']): ?>
                                        <img class="card-img-top rounded-4" src="<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                    <?php else: ?>
                                        <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/placeholder.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body px-0">
                                        <h3 class="h6 mb-1 text-dark"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="price mb-2 text-primary"><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                                    </div>
                                </a>
                                <div class="px-2">
                                    <button type="button" class="btn btn-outline-dark btn-sm w-100 js-add-to-cart" data-product-id="<?= (int)$product['id'] ?>">Thêm vào giỏ</button>
                                </div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback: Hiển thị thông báo nếu không có sản phẩm -->
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Chưa có sản phẩm nổi bật</h5>
                                <p class="text-muted">Hãy thêm sản phẩm qua <a href="/Webdior/admin/products.php">Admin Panel</a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Các giá trị nổi bật (USP) -->
        <section class="py-4 border-top border-bottom bg-dark text-white">
            <div class="container">
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fas fa-certificate fa-2x mb-2"></i>
                                <h6 class="mb-1">Chính hãng 100%</h6>
                                <small class="text-light">Cam kết sản phẩm chính hãng 100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                                <h6 class="mb-1">Chính sách đổi trả</h6>
                                <small class="text-light">Chính sách đổi hàng và tích điểm thành viên</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fas fa-headset fa-2x mb-2"></i>
                                <h6 class="mb-1">Tư vấn & hỗ trợ</h6>
                                <small class="text-light">Tư vấn và hỗ trợ gói quà miễn phí</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fas fa-truck fa-2x mb-2"></i>
                                <h6 class="mb-1">Miễn phí giao hàng</h6>
                                <small class="text-light">Miễn phí giao hàng cho hóa đơn từ 1.000.000đ</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include 'includes/footer.php'; ?>

    <?php include 'includes/scripts.php'; ?>
    <script>
    window.CART_CSRF = '<?php echo htmlspecialchars(csrf_generate_token('cart')); ?>';
    </script>
</body>
</html>

