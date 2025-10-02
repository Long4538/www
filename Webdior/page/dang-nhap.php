<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Webdior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Webdior/assets/css/style.css">
    <!-- Biểu tượng trang (Favicon) -->
    <link rel="icon" type="image/png" sizes="32x32" href="/Webdior/images/logoDior.png?v=1">
</head>
<body class="bg-light">
    <!-- Header đơn giản -->
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/Webdior/">
                <img src="/Webdior/images/logoDior.png" alt="Dior Logo" height="28" class="me-2">
                <span class="visually-hidden">Webdior</span>
            </a>
            <a href="/Webdior/" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Về trang chủ
            </a>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h1 class="h4 mb-2" style="font-family:'Playfair Display',serif">Đăng nhập</h1>
                                <p class="text-secondary">Chào mừng bạn trở lại</p>
                            </div>

                            <form action="#" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-secondary"></i>
                                        </span>
                                        <input type="email" class="form-control border-start-0" id="email" name="email" 
                                               placeholder="your@email.com" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-secondary"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" id="password" name="password" 
                                               placeholder="••••••••" required>
                                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                                            <i class="fas fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label text-sm" for="remember">
                                            Ghi nhớ đăng nhập
                                        </label>
                                    </div>
                                    <a href="#" class="text-decoration-none text-sm">Quên mật khẩu?</a>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                </button>

                                <div class="text-center">
                                    <span class="text-secondary">Chưa có tài khoản? </span>
                                    <a href="/Webdior/page/dang-ky.php" class="text-decoration-none">Đăng ký ngay</a>
                                </div>
                            </form>

                            <hr class="my-4">

                            <!-- Đăng nhập mạng xã hội -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fab fa-facebook-f me-2"></i>Đăng nhập với Facebook
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="fab fa-google me-2"></i>Đăng nhập với Google
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin hỗ trợ -->
                    <div class="text-center mt-4">
                        <p class="text-secondary mb-2">Cần hỗ trợ?</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-decoration-none text-sm">Liên hệ</a>
                            <span class="text-secondary">•</span>
                            <a href="#" class="text-decoration-none text-sm">Hướng dẫn</a>
                            <span class="text-secondary">•</span>
                            <a href="#" class="text-decoration-none text-sm">Chính sách</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-top py-3 bg-white mt-5">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                <img src="/Webdior/images/logoDior.png" alt="Dior Logo" height="20">
                <span class="text-secondary">Webdior | Nước hoa chính hãng</span>
            </div>
            <p class="text-secondary mb-0" style="font-size: 0.875rem;">© <?php echo date('Y'); ?> Webdior. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS cho trang đăng nhập -->
    <script src="/Webdior/js/dang-nhap.js"></script>
</body>
</html>
