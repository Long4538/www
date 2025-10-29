<?php
require_once "../admin/Database.php";

class AdminModel extends Database {
    public function checkLogin($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }
}
