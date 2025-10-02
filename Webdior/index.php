<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webdior - Nước hoa chính hãng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CSS tuỳ chỉnh của dự án -->
    <link rel="stylesheet" href="/Webdior/assets/css/style.css">
    <!-- Biểu tượng trang (Favicon) -->
    <link rel="icon" type="image/png" sizes="32x32" href="/Webdior/images/logoDior.png?v=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/Webdior/images/logoDior.png?v=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/Webdior/images/logoDior.png?v=1">
    <!-- Font Awesome 6 (CSS) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>
    <!-- Header / Thanh điều hướng (Navbar - Bootstrap) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/Webdior/">
                <img src="/Webdior/images/logoDior.png" alt="Dior Logo" height="28" class="me-2">
                <span class="visually-hidden">Webdior</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/Webdior/page/gioi-thieu.php">Giới thiệu</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#bo-suu-tap" id="dropdownCollections" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bộ sưu tập</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownCollections">
                            <li><a class="dropdown-item" href="#nuoc-hoa-nam">Nước hoa nam</a></li>
                            <li><a class="dropdown-item" href="#nuoc-hoa-nu">Nước hoa nữ</a></li>
                            <li><a class="dropdown-item" href="#unisex">Unisex</a></li>
                            <li><a class="dropdown-item" href="#body-spray">Body spray</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Theo nhu cầu</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#van-phong">Văn phòng</a></li>
                                    <li><a class="dropdown-item" href="#hen-ho">Hẹn hò</a></li>
                                    <li><a class="dropdown-item" href="#the-thao">Thể thao</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#tin-tuc">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lien-he">Liên hệ</a></li>
                </ul>
                <form class="d-none d-md-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Tìm kiếm mùi hương..." aria-label="Tìm kiếm">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="d-flex align-items-center gap-2 ms-2">
                    <a href="#" class="text-dark" title="Giỏ hàng" style="position: relative;">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">0</span>
                    </a>
                    <a href="/Webdior/page/dang-nhap.php" class="text-dark" title="Đăng nhập">
                        <i class="fas fa-user fs-5"></i>
                    </a>
                    <button class="btn btn-dark btn-sm ms-2">Liên hệ tư vấn</button>
                </div>
            </div>
        </div>
    </nav>

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
                            <img src="/Webdior/assets/img/hero-bottle.jpg" alt="Hero Bottle">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Danh mục -->
        <section id="bo-suu-tap" class="py-4">
            <div class="container">
                <h2 class="h3 mb-3" style="font-family:'Playfair Display',serif">Danh mục</h2>
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#nuoc-hoa-nam">Nước hoa nam</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#nuoc-hoa-nu">Nước hoa nữ</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#unisex">Unisex</a></div>
                    <div class="col"><a class="d-block text-center p-3 rounded-3 category-card" href="#body-spray">Body spray</a></div>
                </div>
            </div>
        </section>

        <!-- Sản phẩm nổi bật -->
        <section id="noi-bat" class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h2 class="h3 m-0" style="font-family:'Playfair Display',serif">Sản phẩm nổi bật</h2>
                    <a class="text-secondary" href="#tat-ca">Xem tất cả</a>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/sauvage-edt-b.jpg" alt="Sản phẩm 1">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Sauvage EDT</h3>
                                <p class="price mb-2">2.890.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/blooming-bouquet-b.jpg" alt="Sản phẩm 2">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Miss Dior Blooming Bouquet</h3>
                                <p class="price mb-2">3.150.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/dior-homme-intense-b.jpg" alt="Sản phẩm 3">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">Dior Homme Intense</h3>
                                <p class="price mb-2">3.490.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                    <div class="col">
                        <article class="card bg-transparent border-0 product-card p-2">
                            <img class="card-img-top rounded-4" src="/Webdior/images/sanpham/jadore-parfum-b.jpg" alt="Sản phẩm 4">
                            <div class="card-body px-0">
                                <h3 class="h6 mb-1">J’adore Parfum d’Eau</h3>
                                <p class="price mb-2">3.990.000₫</p>
                                <button class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- Các giá trị nổi bật (USP) -->
        <section class="py-4 border-top border-bottom">
            <div class="container">
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <div class="col"><div class="usp-item p-3 text-center rounded-3">Chính hãng 100%</div></div>
                    <div class="col"><div class="usp-item p-3 text-center rounded-3">Giao hàng nhanh</div></div>
                    <div class="col"><div class="usp-item p-3 text-center rounded-3">Tư vấn mùi hương miễn phí</div></div>
                    <div class="col"><div class="usp-item p-3 text-center rounded-3">Đổi trả dễ dàng</div></div>
                </div>
            </div>
        </section>


        <!-- Cửa hàng (địa điểm) -->
        <section id="lien-he" class="py-4">
            <div class="container">
                <h2 class="h3 mb-3" style="font-family:'Playfair Display',serif">Cửa hàng</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-transparent border border-secondary-subtle h-100">
                            <h3 class="h5">Hà Nội</h3>
                            <p class="mb-0 text-secondary">17 Ngõ 236 Khương Đình, Thanh Xuân</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-transparent border border-secondary-subtle h-100">
                            <h3 class="h5">Hà Nội</h3>
                            <p class="mb-0 text-secondary">108 Hoà Mã, Hai Bà Trưng</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-transparent border border-secondary-subtle h-100">
                            <h3 class="h5">TP.HCM</h3>
                            <p class="mb-0 text-secondary">225F Trần Quang Khải, Quận 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-top py-3 bg-light">
        <div class="container d-grid" style="grid-template-columns:1fr auto auto; gap:16px; align-items:center;">
            <div class="d-flex align-items-center gap-2">
                <img src="/Webdior/images/logoDior.png" alt="Dior Logo" height="22">
                <p class="mb-0 text-secondary">Webdior | Nước hoa chính hãng</p>
            </div>
            <nav class="d-flex align-items-center gap-3">
                <a class="text-secondary" href="#">Chính sách bảo mật</a>
                <a class="text-secondary" href="#">Thanh toán</a>
                <a class="text-secondary" href="#">Bảo hành</a>
            </nav>
            <div class="d-flex gap-2 text-secondary">
                <a class="text-secondary" href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a class="text-secondary" href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a class="text-secondary" href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </footer>

    <!-- Gói JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS cho trang chủ -->
    <script src="/Webdior/js/trang-chu.js"></script>
</body>
</html>

