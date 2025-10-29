<?php 
session_start();
$page_title = 'Quên mật khẩu | Webdior';
require_once __DIR__ . '/../config/security.php';
$prefill = isset($_GET['email']) ? trim($_GET['email']) : ($_SESSION['forgot_email'] ?? '');
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
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="text-center mb-4">
                        <h1 class="h4 mb-0" style="font-family:'Playfair Display',serif">Quên mật khẩu</h1>
                    </div>

                    <?php if (!empty($_SESSION['forgot_errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['forgot_errors'] as $e): ?>
                                <div><?php echo htmlspecialchars($e); ?></div>
                            <?php endforeach; unset($_SESSION['forgot_errors']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['forgot_success'])): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($_SESSION['forgot_success']); unset($_SESSION['forgot_success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php $csrf = csrf_generate_token('forgot'); ?>
                    <form action="/Webdior/reset-password-process.php" method="POST" class="bg-white p-4 rounded shadow-sm" id="forgot-form">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control pe-5" id="email" name="email" required value="<?php echo htmlspecialchars($prefill); ?>">
                            <span id="email-check-icon" class="position-absolute top-50 end-0 translate-middle-y me-3"></span>
                            <div id="email-help" class="form-text">Nhập email và chuyển xuống ô tiếp theo để kiểm tra.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Đặt lại mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100" id="btn-submit" disabled>Cập nhật mật khẩu</button>
                        <p class="small text-muted mt-3 mb-0">Email phải tồn tại thì mới có thể cập nhật mật khẩu.</p>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
</body>
</html>


