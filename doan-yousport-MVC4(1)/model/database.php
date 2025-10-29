<?php
class Database {
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=webshop;charset=utf8",
                "root",   // ✅ user mặc định của XAMPP
                ""        // ✅ mật khẩu trống
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối database thất bại: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
