<?php
// Lấy tất cả tài khoản
function get_all_taikhoan() {
    $sql = "SELECT * FROM users ORDER BY user_id DESC";
    return pdo_query($sql);
}

// Lấy tài khoản theo ID
function get_taikhoan_by_id($id) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    return pdo_query_one($sql, $id);
}

// Thêm tài khoản
function insert_taikhoan($fullname, $password, $email, $role, $phone = null, $address = null) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, password, email, phone, address, role, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    pdo_execute($sql, $fullname, $password_hash, $email, $phone, $address, $role);
}
// Bên trong file "model/taikhoan.php"
function check_admin_login($email, $password) {
    $sql = "SELECT * FROM users WHERE email = ? AND role = 'admin'";
    $admin = pdo_query_one($sql, $email); // Dùng hàm pdo.php của bạn

    if ($admin) {
        // Kiểm tra mật khẩu (hỗ trợ cả password_hash và md5 cũ)
        if (password_verify($password, $admin['password']) || md5($password) === $admin['password']) {
            return $admin; // ✅ Trả về thông tin admin nếu đúng
        }
    }
    return false; // ❌ Trả về false nếu sai
}

// Cập nhật tài khoản
function update_taikhoan($id, $fullname, $password, $email, $role, $phone = null, $address = null) {
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET full_name=?, password=?, email=?, phone=?, address=?, role=? WHERE user_id=?";
        pdo_execute($sql, $fullname, $password_hash, $email, $phone, $address, $role, $id);
    } else {
        $sql = "UPDATE users SET full_name=?, email=?, phone=?, address=?, role=? WHERE user_id=?";
        pdo_execute($sql, $fullname, $email, $phone, $address, $role, $id);
    }
}

// Xóa tài khoản
function delete_taikhoan($id) {
    $sql = "DELETE FROM users WHERE user_id=?";
    pdo_execute($sql, $id);
}
?>
