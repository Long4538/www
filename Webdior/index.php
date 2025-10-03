<?php $page_title = 'Trang chủ | Webdior'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'includes/head.php'; ?>
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
                    <!-- Hàng 1: 4 sản phẩm chính -->
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/sauvage-edt-b.jpg" alt="Dior Sauvage EDT">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Sauvage EDT</h3>
                                <p class="price mb-2">2.890.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/blooming-bouquet-b.jpg" alt="Miss Dior Blooming Bouquet">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Miss Dior Blooming Bouquet</h3>
                                <p class="price mb-2">3.150.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/dior-homme-intense-b.jpg" alt="Dior Homme Intense">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Homme Intense</h3>
                                <p class="price mb-2">3.490.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/jadore-parfum-b.jpg" alt="J'adore Parfum d'Eau">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">J'adore Parfum d'Eau</h3>
                                <p class="price mb-2">3.990.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>

                    <!-- Hàng 2: 4 sản phẩm mới từ LAN Perfume -->
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/jadore-edp-b.jpg" alt="Dior J’adore EDP">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior J’adore EDP</h3>
                                <p class="price mb-2">2.750.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/miss-dior-rose-n-rose-b.jpg" alt="Miss Dior Rose N'Roses">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Miss Dior Rose N'Roses</h3>
                                <p class="price mb-2">3.300.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/sauvage-edp.jpg" alt="Dior Sauvage Parfum">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Sauvage Parfum</h3>
                                <p class="price mb-2">4.150.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/joy-intense-b.jpg" alt="Dior Joy Intense">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Joy Intense</h3>
                                <p class="price mb-2">3.650.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
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
</body>
</html>

