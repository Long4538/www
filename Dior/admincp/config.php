<?php
$host = 'localhost';
$dbname = 'shop_nuochoa_da';
$username = 'root'; // hoặc tài khoản MySQL của bạn
$password = '';     // điền mật khẩu nếu có

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>
