<?php
require_once '../admincp/config.php';

$full_name = "Quản Trị Viên";
$email = "admin@dior.com";
$password = "123456";
$hash = password_hash($password, PASSWORD_DEFAULT);

// Lấy id role admin
$stmt = $pdo->prepare("SELECT id FROM roles WHERE name = 'admin'");
$stmt->execute();
$roles = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$roles) {
    echo "Chưa có role admin, vui lòng thêm vào bảng roles.";
    exit;
}

$sql = "INSERT INTO users (full_name, email, password_hash, role_id, is_active)
        VALUES (?, ?, ?, ?, 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$full_name, $email, $hash, $roles['id']]);

echo "✅ Tạo tài khoản admin thành công!<br>";
echo "Email: $email<br>";
echo "Mật khẩu: $password";