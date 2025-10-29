<?php
/**
 * Xử lý đăng ký tài khoản
 */

session_start();
require_once 'config/database.php';
require_once 'config/security.php';

// Kiểm tra method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Webdior/page/dang-ky.php');
    exit;
}

// Lấy dữ liệu từ form
$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'register')) {
    $_SESSION['register_errors'] = ['Phiên đăng ký không hợp lệ (CSRF). Vui lòng thử lại.'];
    header('Location: /Webdior/page/dang-ky.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Validation
$errors = [];

// Kiểm tra email
if (empty($email)) {
    $errors[] = 'Email không được để trống';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
} else {
    // Kiểm tra email đã tồn tại chưa
    $existingUser = fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
    if ($existingUser) {
        $errors[] = 'Email này đã được sử dụng';
    }
}

// Kiểm tra mật khẩu
if (empty($password)) {
    $errors[] = 'Mật khẩu không được để trống';
} elseif (strlen($password) < 6) {
    $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
}

// Kiểm tra xác nhận mật khẩu
if (empty($confirm_password)) {
    $errors[] = 'Xác nhận mật khẩu không được để trống';
} elseif ($password !== $confirm_password) {
    $errors[] = 'Mật khẩu xác nhận không khớp';
}

// Kiểm tra tên
if (empty($first_name)) {
    $errors[] = 'Tên không được để trống';
}

if (empty($last_name)) {
    $errors[] = 'Họ không được để trống';
}

// Kiểm tra số điện thoại (nếu có)
if (!empty($phone) && !preg_match('/^[0-9+\-\s()]+$/', $phone)) {
    $errors[] = 'Số điện thoại không hợp lệ';
}

// Nếu có lỗi, quay lại trang đăng ký
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_data'] = [
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'phone' => $phone
    ];
    header('Location: /Webdior/page/dang-ky.php');
    exit;
}

try {
    // Hash mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Tạo slug từ tên
    $fullName = $first_name . ' ' . $last_name;
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $fullName)));
    
    // Insert user vào database
    $sql = "INSERT INTO users (email, password, first_name, last_name, phone, is_active, is_admin, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $params = [
        $email,
        $hashedPassword,
        $first_name,
        $last_name,
        $phone ?: null,
        1, // is_active = true
        0  // is_admin = false (user thường)
    ];
    
    $result = executeStatement($sql, $params);
    
    if ($result > 0) {
        // Đăng ký thành công
        $_SESSION['register_success'] = true;
        $_SESSION['register_message'] = 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.';
        
        // Tự động đăng nhập user mới
        $pdo = getDBConnection();
        $newUserId = $pdo->lastInsertId();
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $fullName;
        $_SESSION['is_admin'] = 0;
        
        header('Location: /Webdior/');
        exit;
    } else {
        $_SESSION['register_errors'] = ['Lỗi hệ thống. Vui lòng thử lại sau.'];
        header('Location: /Webdior/page/dang-ky.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['register_errors'] = ['Lỗi hệ thống. Vui lòng thử lại sau.'];
    header('Location: /Webdior/page/dang-ky.php');
    exit;
}
?>
