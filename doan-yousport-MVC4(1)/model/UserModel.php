<?php
require_once "Database.php";

class UserModel extends Database {

    // =============================
    // 🟢 HÀM ĐĂNG KÝ NGƯỜI DÙNG
    // =============================
    // Đăng ký tài khoản
    public function register($user_id, $full_name, $email, $password) {

        $user_id   = trim($user_id);
        $full_name = trim($full_name);
        $email     = trim($email);
         // Mã hóa mật khẩu (dùng password_hash an toàn hơn)
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra trùng user_id hoặc email
        $sql = "SELECT * FROM users WHERE user_id = :user_id OR email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':email' => $email
        ]);

        if ($stmt->rowCount() > 0) {
            return "Tên người dùng hoặc email đã tồn tại!";
        }

        // Thêm user mới
        $sql = "INSERT INTO users (user_id, full_name, email, password) 
                VALUES (:user_id, :full_name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':full_name' => $full_name,
            ':email' => $email,
            ':password' => $hashed
        ]);

        return true;
    }

    // =============================
    // 🟢 HÀM ĐĂNG NHẬP (FULL_NAME HOẶC EMAIL)
    // =============================
    // Đăng nhập bằng user_id
    public function loginByFullNameOrEmail($identifier, $password) {
        // ✅ Cho phép nhập full_name hoặc email để đăng nhập
        $sql = "SELECT * FROM users WHERE full_name = :identifier OR email = :identifier";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':identifier' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ✅ So khớp mật khẩu (vì DB của bạn có thể dùng password_hash hoặc MD5)
         if ($user) {
            // ✅ Nếu dùng password_hash
            if (password_verify($password, $user['password'])) {
                return $user;
            }

            // ✅ Nếu mật khẩu trong DB là MD5
            if ($user['password'] === md5($password)) {
                return $user;
            }
        }

        //Sai thông tin dăng nhập
        return false;
    }
}
