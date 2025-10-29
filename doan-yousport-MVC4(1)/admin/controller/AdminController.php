<?php
require_once "../admin/model/AdminModel.php";

class AdminController {

    // Hàm đăng nhập admin
    public function login() {
        if (isset($_POST['dangnhap'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $model = new AdminModel();
            $admin = $model->checkLogin($username, $password);

            if ($admin) {
                $_SESSION['admin'] = $admin;
                // Chuyển trực tiếp sang admin/index.php
                header("Location: /doan-bitis-MVC3(1)/admin/index.php");
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                include "../admin/admin_login.php";
            }
        } else {
            include "../admin/admin_login.php";
        }
    }

    // Hàm hiển thị dashboard
    public function dashboard() {
        if (!isset($_SESSION['admin'])) {
            header("Location: /doan-bitis-MVC3(1)/admin/admin_login.php");
            exit;
        }
        // Nếu muốn vẫn hiển thị dashboard, có thể include dashboard.php
        include "../admin/dashboard.php";
    }

    // Hàm logout
    public function logout() {
        session_destroy();
        // Sau logout chuyển về admin/index.php
        header("Location: /doan-bitis-MVC3(1)/admin/index.php");
        exit;
    }
}
