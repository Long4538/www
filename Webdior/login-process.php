<?php
/**
 * Xử lý đăng nhập
 */

session_start();
require_once 'config/database.php';
require_once 'config/security.php';

// Kiểm tra method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

// Lấy dữ liệu từ form
$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'login')) {
    $_SESSION['login_errors'] = ['Phiên đăng nhập không hợp lệ (CSRF). Vui lòng thử lại.'];
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validation
$errors = [];

if (empty($email)) {
    $errors[] = 'Email không được để trống';
}

if (empty($password)) {
    $errors[] = 'Mật khẩu không được để trống';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

// Nếu có lỗi, quay lại trang đăng nhập
if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['login_data'] = ['email' => $email, 'password' => $password];
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

try {
    // Tìm user trong database
    $user = fetchOne("
        SELECT id, email, password, first_name, last_name, is_admin, is_active 
        FROM users 
        WHERE email = ? AND is_active = 1
    ", [$email]);
    
    if (!$user) {
        $_SESSION['login_errors'] = ['Email hoặc mật khẩu không đúng'];
        $_SESSION['login_data'] = ['email' => $email, 'password' => $password];
        header('Location: /Webdior/page/dang-nhap.php');
        exit;
    }
    
    // Kiểm tra mật khẩu
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_errors'] = ['Email hoặc mật khẩu không đúng'];
        $_SESSION['login_data'] = ['email' => $email, 'password' => $password];
        header('Location: /Webdior/page/dang-nhap.php');
        exit;
    }
    
    // Đăng nhập thành công
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['login_success'] = true;
    
    // Redirect dựa trên quyền
    if ($user['is_admin']) {
        header('Location: /Webdior/admin/products.php');
    } else {
        header('Location: /Webdior/');
    }
    exit;
    
} catch (Exception $e) {
    $_SESSION['login_errors'] = ['Lỗi hệ thống. Vui lòng thử lại sau.'];
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}
?>
