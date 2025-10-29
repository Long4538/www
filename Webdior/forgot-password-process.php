<?php
session_start();
require_once 'config/database.php';
require_once 'config/security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'forgot')) {
    $_SESSION['forgot_errors'] = ['Phiên không hợp lệ (CSRF). Vui lòng thử lại.'];
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$_SESSION['forgot_email'] = $email;

$errors = [];
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

if (!empty($errors)) {
    $_SESSION['forgot_errors'] = $errors;
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

// Tìm user theo email
$user = fetchOne("SELECT id, email FROM users WHERE email = ? AND is_active = 1", [$email]);
if (!$user) {
    // Không tiết lộ tồn tại hay không (tránh lộ thông tin)
    $_SESSION['forgot_success'] = 'Nếu email tồn tại, chúng tôi đã gửi liên kết đặt lại mật khẩu.';
    header('Location: /Webdior/page/quen-mat-khau.php');
    exit;
}

// Tạo token và lưu tạm trong session (DEV). Sản xuất nên lưu DB bảng password_resets
$token = bin2hex(random_bytes(32));
$_SESSION['password_reset'][$token] = [
    'user_id' => $user['id'],
    'expire' => time() + 3600, // 1 giờ
];

$resetLink = '/Webdior/page/dat-lai-mat-khau.php?token=' . urlencode($token);

// DEV: Hiển thị link ngay trên giao diện
$_SESSION['forgot_success'] = 'Liên kết đặt lại: ' . $resetLink;

header('Location: /Webdior/page/quen-mat-khau.php');
exit;
?>


