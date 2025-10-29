<?php
function check_admin_login($username, $password) {
    $sql = "SELECT * FROM admins WHERE username = ?";
    $conn = pdo_get_connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        return $admin;
    }
    return false;
}
