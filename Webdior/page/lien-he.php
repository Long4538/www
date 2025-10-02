<?php $page_title = 'Liên hệ | Webdior'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include '../includes/head.php'; ?>
</head>
<body class="bg-light">
    <?php include '../includes/header.php'; ?>

    <main class="py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/Webdior/" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                </ol>
            </nav>

            <!-- Tiêu đề trang -->
            <div class="text-center mb-5">
                <h1 class="h2 mb-0" style="font-family:'Playfair Display',serif">Liên hệ</h1>
            </div>

            <div class="row g-5">
                <!-- Thông tin liên hệ -->
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded shadow-sm h-100">
                        <h2 class="h4 mb-4" style="font-family:'Playfair Display',serif">Thông tin liên hệ</h2>
                        
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-phone text-primary me-2"></i>Hotline</h5>
                            <ul class="list-unstyled ms-4">
                                <li class="mb-2">Khương Đình: <strong>058 950 6666</strong></li>
                                <li class="mb-2">Hoà Mã: <strong>091 116 5686</strong></li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                            <p class="ms-4 mb-0">
                                <a href="mailto:webdiorstore@gmail.com" class="text-decoration-none">webdiorstore@gmail.com</a>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-map-marker-alt text-primary me-2"></i>Địa chỉ cửa hàng</h5>
                            <ul class="list-unstyled ms-4">
                                <li class="mb-3">
                                    <strong>Hà Nội 1:</strong><br>
                                    236 Khương Đình, Hạ Đình, Thanh Xuân, Hà Nội
                                </li>
                                <li class="mb-3">
                                    <strong>Hà Nội 2:</strong><br>
                                    108 Hoà Mã, Hai Bà Trưng, Hà Nội
                                </li>
                                <li class="mb-3">
                                    <strong>TP.HCM:</strong><br>
                                    225F Trần Quang Khải, Tân Định, Quận 1, TP.HCM
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="mb-3"><i class="fas fa-share-alt text-primary me-2"></i>Theo dõi chúng tôi</h5>
                            <div class="ms-4">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                    <i class="fab fa-facebook-f me-1"></i>Facebook
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm me-2 mb-2">
                                    <i class="fab fa-instagram me-1"></i>Instagram
                                </a>
                                <a href="#" class="btn btn-outline-dark btn-sm mb-2">
                                    <i class="fab fa-tiktok me-1"></i>TikTok
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form liên hệ -->
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded shadow-sm h-100">
                        <h2 class="h4 mb-4" style="font-family:'Playfair Display',serif">Liên hệ với chúng tôi</h2>
                        
                        <form action="#" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Chủ đề</label>
                                <select class="form-select" id="subject" name="subject">
                                    <option value="">Chọn chủ đề...</option>
                                    <option value="tu-van">Tư vấn sản phẩm</option>
                                    <option value="dat-hang">Đặt hàng</option>
                                    <option value="bao-hanh">Bảo hành - Đổi trả</option>
                                    <option value="hop-tac">Hợp tác kinh doanh</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" 
                                          placeholder="Nhập nội dung tin nhắn của bạn..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">
                                <i class="fas fa-paper-plane me-2"></i>Gửi ngay
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bản đồ (placeholder) -->
            <div class="mt-5">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h3 class="h4 mb-3" style="font-family:'Playfair Display',serif">Vị trí cửa hàng</h3>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                            <p class="mb-0">Bản đồ Google Maps sẽ được tích hợp tại đây</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <?php include '../includes/scripts.php'; ?>
</body>
</html>
