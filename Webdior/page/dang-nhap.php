<?php 
$page_title = 'Đăng nhập | Webdior'; 
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
                    <li class="breadcrumb-item active" aria-current="page">Đăng Nhập</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-0" style="font-family:'Playfair Display',serif">Đăng Nhập</h1>
                    </div>

                    <?php if (isset($_SESSION['login_errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['login_errors'] as $error): ?>
                                <div><?= htmlspecialchars($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['login_errors']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['login_success'])): ?>
                        <div class="alert alert-success">
                            Đăng nhập thành công!
                        </div>
                        <?php unset($_SESSION['login_success']); ?>
                    <?php endif; ?>

                    <?php require_once __DIR__ . '/../config/security.php'; $csrf_login = csrf_generate_token('login'); $old = $_SESSION['login_data'] ?? []; unset($_SESSION['login_data']); ?>
                    <form action="/Webdior/login-process.php" method="POST" class="bg-white p-4 rounded shadow-sm">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_login); ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required value="<?php echo htmlspecialchars($old['password'] ?? ''); ?>">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ghi nhớ mật khẩu
                                </label>
                            </div>
                            <a href="/Webdior/page/quen-mat-khau.php" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 mb-3">Đăng nhập</button>

                        <div class="text-center mb-3">
                            <span>Bạn chưa có tài khoản? </span>
                            <a href="/Webdior/page/dang-ky.php" class="text-decoration-none fw-bold">Đăng ký ngay</a>
                        </div>

                        <div class="text-center mb-3">
                            <a href="/Webdior/page/quen-mat-khau.php" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>

                        <hr class="my-3">

                        <!-- Đăng nhập Google -->
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
