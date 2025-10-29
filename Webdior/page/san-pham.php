<?php
// Thiết lập tiêu đề trang
$page_title = "Thông tin sản phẩm - DIOR";
require_once __DIR__ . '/../config/security.php';
$csrf_cart = csrf_generate_token('cart');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include '../includes/head.php'; ?>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bg-light py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/Webdior/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/Webdior/#nuoc-hoa-nam">Bộ sưu tập</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thông tin sản phẩm</li>
            </ol>
        </div>
    </nav>

    <!-- Chi tiết sản phẩm -->
    <main class="py-5">
        <div class="container">
            <div class="row">
                <!-- Hình ảnh sản phẩm -->
                <div class="col-lg-6 mb-4">
                    <div class="product-image-container">
                        <img src="/Webdior/images/products/product-placeholder.jpg" 
                             alt="Tên sản phẩm" 
                             class="img-fluid rounded shadow-sm" 
                             id="main-product-image">
                        
                        <!-- Thumbnail images (sẽ được thêm từ database) -->
                        <div class="row mt-3">
                            <div class="col-3">
                                <img src="/Webdior/images/products/product-placeholder.jpg" 
                                     alt="Hình ảnh 1" 
                                     class="img-fluid rounded border thumbnail-image" 
                                     style="cursor: pointer;">
                            </div>
                            <div class="col-3">
                                <img src="/Webdior/images/products/product-placeholder.jpg" 
                                     alt="Hình ảnh 2" 
                                     class="img-fluid rounded border thumbnail-image" 
                                     style="cursor: pointer;">
                            </div>
                            <div class="col-3">
                                <img src="/Webdior/images/products/product-placeholder.jpg" 
                                     alt="Hình ảnh 3" 
                                     class="img-fluid rounded border thumbnail-image" 
                                     style="cursor: pointer;">
                            </div>
                            <div class="col-3">
                                <img src="/Webdior/images/products/product-placeholder.jpg" 
                                     alt="Hình ảnh 4" 
                                     class="img-fluid rounded border thumbnail-image" 
                                     style="cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <!-- Tên sản phẩm -->
                        <h1 class="h2 mb-2" id="product-name">Tên sản phẩm</h1>
                        
                        <!-- Danh mục & SKU -->
                        <p class="text-muted mb-3 small">
                            Danh mục: <span id="product-category">Nước hoa Nước hoa nam</span> • SKU: <span id="product-sku">1861Renaissance</span>
                        </p>
                        
                        <!-- Giá sản phẩm -->
                        <div class="price-section mb-4">
                            <span class="h2 text-dark fw-bold" id="product-price">0₫</span>
                        </div>
                        
                        <!-- Dung tích & Nồng độ & Số lượng -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2 text-muted">Dung Tích:</span>
                                <span class="badge bg-light text-dark border" id="product-volume-display">100ml</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="me-2 text-muted">Nồng Độ:</span>
                                <span class="badge bg-light text-dark border" id="product-concentration-display">Eau de Parfum</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-3 text-muted">Số Lượng:</span>
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                                    <input type="text" class="form-control text-center" value="1" id="product-quantity-input">
                                    <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nút hành động -->
                        <div class="product-actions mb-4">
                            <div class="d-flex">
                                <button class="btn btn-dark btn-lg me-3 flex-grow-1" id="buy-now">
                                    Mua ngay
                                </button>
                                <button class="btn btn-outline-dark btn-lg flex-grow-1" id="add-to-cart">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                        
                        <!-- Contact Info -->
                        <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                            <i class="fas fa-comment-dots fa-lg me-2 text-primary"></i> <span class="me-3">Zalo</span> |
                            <i class="fab fa-facebook-f fa-lg mx-2 text-primary"></i> <span class="me-3">Fanpage</span> |
                            <i class="fas fa-phone-alt fa-lg mx-2 text-primary"></i> <span class="fw-bold">058 950 6666</span>
                        </div>
                        
                        <!-- Product Attributes Grid -->
                        <div class="row row-cols-2 g-3 mb-4">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-flask me-2 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Thương hiệu</small>
                                        <span class="fw-bold" id="attr-brand">DIOR</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fill-drip me-2 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Nồng độ</small>
                                        <span class="fw-bold" id="attr-concentration">Eau de Parfum</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Độ lưu hương</small>
                                        <span class="fw-bold" id="attr-duration">8-10h</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wind me-2 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Độ tỏa hương</small>
                                        <span class="fw-bold" id="attr-sillage">1 sải tay</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-mars me-2 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Giới tính</small>
                                        <span class="fw-bold" id="attr-gender">Nam</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chia sẻ -->
                        <div class="d-flex align-items-center border-top pt-3">
                            <span class="me-3 text-muted">Chia Sẻ:</span>
                            <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fas fa-comment-dots fa-lg"></i></a> <!-- Zalo placeholder -->
                            <a href="#" class="text-dark"><i class="fas fa-link fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Thông tin chi tiết sản phẩm -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Mô tả chi tiết -->
                    <div class="product-details mb-5">
                        <h3 class="mb-4">Mô tả sản phẩm</h3>
                        <div id="product-full-description">
                            <!-- Nội dung mô tả sẽ được load từ database -->
                        </div>
                    </div>


                    <!-- Hướng dẫn sử dụng -->
                    <div class="usage-guide mb-5">
                        <h3 class="mb-4">Hướng dẫn sử dụng</h3>
                        <div id="usage-instructions">
                            <ul>
                                <li>Ưu tiên xịt nước hoa vào các vị trí như cổ tay, khuỷu tay, sau tai, gáy và cổ trước.</li>
                                <li>Sau khi xịt nước hoa, tránh việc chà xát hoặc làm khô da bằng bất kỳ vật dụng nào khác.</li>
                                <li>Xịt nước hoa từ khoảng cách 15-20 cm với một lực xịt mạnh và dứt khoát.</li>
                                <li>Hiệu quả của nước hoa có thể thay đổi tùy thuộc vào thời gian, không gian, cơ địa và thói quen sinh hoạt.</li>
                                <li>Nên mang theo nước hoa bên mình hoặc sử dụng các mẫu nhỏ tiện lợi để dễ dàng bổ sung khi cần.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bảo quản nước hoa -->
                    <div class="storage-guide mb-5">
                        <h3 class="mb-4">Bảo quản nước hoa</h3>
                        <div id="storage-instructions">
                            <ul>
                                <li>Nước hoa thường không có hạn sử dụng cụ thể, tuy nhiên, một số loại có thể có hạn sử dụng từ 24 đến 36 tháng.</li>
                                <li>Bảo quản nước hoa ở nơi khô ráo, thoáng mát, tránh ánh nắng mặt trời, nhiệt độ cao hoặc quá lạnh.</li>
                                <li>Tránh để nước hoa trong cốp xe hoặc các khu vực có nhiệt độ thay đổi thất thường.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="product-info-details mb-5">
                        <h3 class="mb-4">Thông tin sản phẩm</h3>
                        <div id="additional-product-info">
                            <ul>
                                <li>Hạn sử dụng và ngày sản xuất được in trên bao bì sản phẩm.</li>
                                <li>Sản phẩm chính hãng 100% từ DIOR.</li>
                                <li>Cam kết chất lượng và uy tín.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Chính sách bảo hành -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Chính sách bảo hành</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">DIOR sẽ hỗ trợ khách hàng đổi sản phẩm trong vòng 03 ngày kể từ ngày mua tại cửa hàng hoặc 03 ngày kể từ ngày nhận hàng online.</p>
                        </div>
                    </div>

                    <!-- Chính sách đổi trả -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Chính sách đổi trả</h5>
                        </div>
                        <div class="card-body">
                            <h6>Điều kiện đổi hàng:</h6>
                            <ul class="small">
                                <li>Sản phẩm chưa sử dụng, còn nguyên seal</li>
                                <li>Sản phẩm bị hư hỏng do lỗi sản xuất</li>
                                <li>Giao sai hoặc nhầm lẫn mùi hương</li>
                            </ul>
                            <p class="small text-muted mb-0">Chỉ nhận đổi hàng khi có video nhận hàng</p>
                        </div>
                    </div>

                    <!-- Thông tin liên hệ -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Thông tin liên hệ</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><i class="fas fa-phone me-2"></i> Hotline: 1900-xxxx</p>
                            <p class="mb-2"><i class="fas fa-envelope me-2"></i> Email: info@dior.com</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> Cửa hàng DIOR gần nhất</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sản phẩm liên quan -->
    <section class="py-5">
        <div class="container">
            <h3 class="mb-4">Sản phẩm liên quan</h3>
            <div class="row" id="related-products">
                <!-- Sản phẩm liên quan sẽ được load từ database -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 product-card">
                        <img src="/Webdior/images/products/related-1.jpg" class="card-img-top" alt="Sản phẩm liên quan 1">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Sản phẩm liên quan 1</h6>
                            <p class="card-text text-muted small">Mô tả ngắn</p>
                            <div class="mt-auto">
                                <p class="h6 text-primary mb-2">0 ₫</p>
                                <a href="#" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 product-card">
                        <img src="/Webdior/images/products/related-2.jpg" class="card-img-top" alt="Sản phẩm liên quan 2">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Sản phẩm liên quan 2</h6>
                            <p class="card-text text-muted small">Mô tả ngắn</p>
                            <div class="mt-auto">
                                <p class="h6 text-primary mb-2">0 ₫</p>
                                <a href="#" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 product-card">
                        <img src="/Webdior/images/products/related-3.jpg" class="card-img-top" alt="Sản phẩm liên quan 3">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Sản phẩm liên quan 3</h6>
                            <p class="card-text text-muted small">Mô tả ngắn</p>
                            <div class="mt-auto">
                                <p class="h6 text-primary mb-2">0 ₫</p>
                                <a href="#" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 product-card">
                        <img src="/Webdior/images/products/related-4.jpg" class="card-img-top" alt="Sản phẩm liên quan 4">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Sản phẩm liên quan 4</h6>
                            <p class="card-text text-muted small">Mô tả ngắn</p>
                            <div class="mt-auto">
                                <p class="h6 text-primary mb-2">0 ₫</p>
                                <a href="#" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
    <script>
    window.CART_CSRF = '<?php echo htmlspecialchars($csrf_cart); ?>';
    </script>
</body>
</html>
