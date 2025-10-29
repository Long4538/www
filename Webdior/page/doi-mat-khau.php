<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}
$page_title = 'Đổi mật khẩu | Webdior';
require_once __DIR__ . '/../config/security.php';
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
                        <h1 class="h4 mb-0" style="font-family:'Playfair Display',serif">Đổi mật khẩu</h1>
                    </div>

                    <?php if (!empty($_SESSION['change_errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['change_errors'] as $e): ?>
                                <div><?php echo htmlspecialchars($e); ?></div>
                            <?php endforeach; unset($_SESSION['change_errors']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['change_success'])): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['change_success']); unset($_SESSION['change_success']); ?></div>
                    <?php endif; ?>

                    <?php $csrf = csrf_generate_token('change'); ?>
                    <form action="/Webdior/change-password-process.php" method="POST" class="bg-white p-4 rounded shadow-sm">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
</body>
</html>


