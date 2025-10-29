<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$message = "";
require_once __DIR__ . "/../../controller/UserController.php";
$controller = new UserController();
$controller->handleLogin();
?>


    <!-- Container để căn giữa -->
    <div class="auth-container">
        
        <div class="auth-box">
            <?php if (!empty($_SESSION['success_message'])): ?>
                <div style="
                    color: green;
                    text-align: center;
                    margin-bottom: 15px;
                    font-weight: bold;
                ">
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); // xóa để không hiện lại ?>
            <?php endif; ?>

            <!-- Logo -->
            <div>
                <img src="../view/images/header/header-logo.png" alt="Bitis Logo" class="logo-login">
            </div>

            <h2>Đăng nhập</h2>

            <?php if ($message): ?>
                <div class="message <?= $message === 'Bạn đã đăng nhập thành công' ? 'success' : 'error' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? '') ?>">

                <div class="form-group">
                    <input type="text" name="identifier" placeholder="Tên đăng nhập" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>
                
                <button type="submit" class="btn">Đăng nhập</button>
            </form>


            <div class="redirect">
                <span>Bạn chưa có tài khoản?</span>
                <a href="index.php?act=register" class="redirect-link">Đăng ký</a>
            </div>

            <div style="text-align:center;margin-top:24px;">
                <a href="../controller/index.php" class="home-link">&larr; Trở về trang chủ</a>
            </div>
        </div>
    </div>

