<?php
// Đảm bảo biến $error luôn tồn tại, dù có lỗi hay không
$error = $error ?? ""; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="view/css/admin_login.css">
    <style>
        /* ... (Giữ nguyên style của bạn) ... */
        body {
            background: #f1f2f6; display: flex; justify-content: center;
            align-items: center; height: 100vh; font-family: Arial, sans-serif;
        }
        .login-container {
            background: white; padding: 40px; border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1); width: 350px;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px;}
        input[type="email"], input[type="password"] {
            width: 100%; padding: 10px; border: 1px solid #ccc;
            border-radius: 5px; box-sizing: border-box; /* Thêm cái này cho chắc */
        }
        .btn-login {
            width: 100%; background: #007bff; color: white; padding: 10px;
            border: none; border-radius: 5px; cursor: pointer;
        }
        .btn-login:hover { background: #0056b3; }
        .error {
            color: red; text-align: center; margin-bottom: 10px;
        }
        .note { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>

<div class="login-container">
    <form method="post" action="index.php?act=handle_login">
        <h2>Đăng nhập quản trị</h2>
        
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="form-group">
            <label for="email">Email đăng nhập</label>
            <input type="email" id="email" name="email" placeholder="Nhập email admin" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>

        <button type="submit" name="login_admin" class="btn-login">Đăng nhập</button>

        <p class="note">← <a href="../index.php">Quay lại trang chủ</a></p>
    </form>
</div>

</body>
</html>