<?php 
$page_title = 'Đăng ký | Webdior'; 
session_start();

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['is_admin']) {
        header('Location: /Webdior/admin/products.php');
    } else {
        header('Location: /Webdior/');
    }
    exit;
}
?>
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
                    <li class="breadcrumb-item active" aria-current="page">Đăng Ký</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-0" style="font-family:'Playfair Display',serif">Đăng Ký</h1>
                    </div>

                    <?php if (isset($_SESSION['register_errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['register_errors'] as $error): ?>
                                <div><?= htmlspecialchars($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['register_errors']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['register_message'] ?? 'Đăng ký thành công!') ?>
                        </div>
                        <?php unset($_SESSION['register_success'], $_SESSION['register_message']); ?>
                    <?php endif; ?>

                    <?php 
                    // Xóa dữ liệu session sau khi hiển thị
                    unset($_SESSION['register_data']); 
                    ?>

                    <?php require_once __DIR__ . '/../config/security.php'; $csrf_register = csrf_generate_token('register'); ?>
                    <form action="/Webdior/register-process.php" method="POST" class="bg-white p-4 rounded shadow-sm">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_register); ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required 
                                       value="<?= htmlspecialchars($_SESSION['register_data']['first_name'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required 
                                       value="<?= htmlspecialchars($_SESSION['register_data']['last_name'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   value="<?= htmlspecialchars($_SESSION['register_data']['email'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?= htmlspecialchars($_SESSION['register_data']['phone'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <!-- Thông tin chính sách -->
                        <div class="mb-3">
                            <p class="text-muted small">
                                Thông tin cá nhân của bạn sẽ được sử dụng để tăng cường trải nghiệm sử dụng website, 
                                để quản lý truy cập vào tài khoản của bạn, và cho các mục đích cụ thể khác được mô tả trong 
                                <a href="#" class="text-decoration-none">chính sách riêng tư</a> của chúng tôi.
                            </p>
                        </div>

                        <!-- Checkbox đồng ý điều khoản -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng dịch vụ</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 mb-3">Đăng ký</button>

                        <div class="text-center mb-3">
                            <span>Bạn đã có tài khoản? </span>
                            <a href="/Webdior/page/dang-nhap.php" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                        </div>

                        <hr class="my-3">

                        <!-- Đăng ký Google -->
                        <button type="button" class="btn btn-outline-danger w-100">
                            <i class="fab fa-google me-2"></i>Đăng nhập bằng Google
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <?php include '../includes/scripts.php'; ?>
</body>
</html>
