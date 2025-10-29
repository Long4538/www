<?php
session_start();
require_once 'config/security.php';
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'reset') && !csrf_validate_token($csrf, 'forgot')) {
    $_SESSION['forgot_errors'] = ['Phiên không hợp lệ (CSRF).'];
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['forgot_errors'] = ['Email không hợp lệ.'];
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

if (strlen($password) < 6 || $password !== $password_confirm) {
    $_SESSION['forgot_errors'] = ['Mật khẩu tối thiểu 6 ký tự và phải khớp.'];
    header('Location: /Webdior/page/quen-mat-khau.php?email=' . urlencode($email));
    exit;
}

$user = fetchOne("SELECT id FROM users WHERE email = ? AND is_active = 1", [$email]);
if (!$user) {
    $_SESSION['forgot_errors'] = ['Email không tồn tại.'];
    header('Location: /Webdior/page/quen-mat-khau.php?email=' . urlencode($email));
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
executeStatement("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?", [$hashed, $user['id']]);

$_SESSION['login_success'] = true;
$_SESSION['login_message'] = 'Đã cập nhật mật khẩu. Vui lòng đăng nhập.';
header('Location: /Webdior/page/dang-nhap.php');
exit;
?>


