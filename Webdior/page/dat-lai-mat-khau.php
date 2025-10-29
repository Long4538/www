<?php 
session_start();
$page_title = 'Đặt lại mật khẩu | Webdior';
require_once __DIR__ . '/../config/security.php';

$token = $_GET['token'] ?? '';
$valid = isset($_SESSION['password_reset'][$token]) && $_SESSION['password_reset'][$token]['expire'] > time();
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
                        <h1 class="h4 mb-0" style="font-family:'Playfair Display',serif">Đặt lại mật khẩu</h1>
                    </div>

                    <?php if (!$valid): ?>
                        <div class="alert alert-danger">Liên kết không hợp lệ hoặc đã hết hạn.</div>
                    <?php else: ?>
                        <?php $csrf = csrf_generate_token('reset'); ?>
                        <form action="/Webdior/reset-password-process.php" method="POST" class="bg-white p-4 rounded shadow-sm">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Nhập lại mật khẩu mới</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Cập nhật mật khẩu</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
</body>
</html>


