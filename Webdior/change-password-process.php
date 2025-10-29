<?php
session_start();
require_once 'config/security.php';
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Webdior/page/doi-mat-khau.php');
    exit;
}

$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'change')) {
    $_SESSION['change_errors'] = ['Phiên không hợp lệ (CSRF).'];
    header('Location: /Webdior/page/doi-mat-khau.php');
    exit;
}

$current = $_POST['current_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

$errors = [];
if (strlen($new) < 6 || $new !== $confirm) {
    $errors[] = 'Mật khẩu mới tối thiểu 6 ký tự và phải khớp.';
}

// Lấy thông tin user
$user = fetchOne("SELECT id, password FROM users WHERE id = ?", [$_SESSION['user_id']]);
if (!$user || !password_verify($current, $user['password'])) {
    $errors[] = 'Mật khẩu hiện tại không đúng.';
}

if (!empty($errors)) {
    $_SESSION['change_errors'] = $errors;
    header('Location: /Webdior/page/doi-mat-khau.php');
    exit;
}

$hashed = password_hash($new, PASSWORD_DEFAULT);
executeStatement("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?", [$hashed, $user['id']]);

$_SESSION['change_success'] = 'Đổi mật khẩu thành công!';
header('Location: /Webdior/page/doi-mat-khau.php');
exit;
?>


