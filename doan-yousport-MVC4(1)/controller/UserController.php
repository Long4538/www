<?php
require_once "../model/UserModel.php";

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // ===== Xử lý đăng ký =====
public function handleRegister() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'] ?? '';
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm'] ?? '');

        // Kiểm tra mật khẩu xác nhận
        if ($password !== $confirm) {
            echo "<script>alert('Mật khẩu xác nhận không khớp!');</script>";
            return;
        }

        // Gọi model để xử lý đăng ký
        $result = $this->userModel->register($user_id, $full_name, $email, $password);

        if ($result === true) {
            // ✅ Lưu thông báo vào session
            $_SESSION['success_message'] = "🎉 Bạn đã đăng ký thành công! Vui lòng đăng nhập để tiếp tục.";

            // ✅ Chuyển hướng sang trang đăng nhập
            header("Location: ../controller/index.php?act=login");
            exit;
        } else {
            echo "<script>alert('$result');</script>";
        }
    }
}


     // ===== Xử lý đăng nhập =====
public function handleLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $identifier = trim($_POST['identifier'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $redirect = $_POST['redirect'] ?? ($_GET['redirect'] ?? '');

        // Lấy thông tin user theo tên hoặc email
        $user = $this->userModel->loginByFullNameOrEmail($identifier, $password);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // ✅ Lưu session đầy đủ
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'] ?? $user['user_id']; // hỗ trợ cả 2 kiểu cột
            $_SESSION['username'] = $user['full_name'] ?? $user['username'] ?? 'Người dùng';

            // ✅ Nếu có redirect thì quay lại trang đó
            if (!empty($redirect)) {
                header("Location: " . $redirect);
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!');</script>";
        }
    }
}

    // ===== Xử lý đăng xuất =====
    public function handleLogout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // ===== Hiển thị profile =====
    public function showProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            require "../view/pages/profile.php";
        } else {
            header("Location: index.php?act=login");
            exit;
        }
    }
}
