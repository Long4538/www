<?php
// Khởi động session nếu chưa
if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}

// Lấy giỏ hàng từ session
$cart = $_SESSION['cart'] ?? [];

// Số lượng sản phẩm trong giỏ
$cart_count = count($cart);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouSport.vn</title>
    <link rel="stylesheet" href="../view/css/index.css">
    <link rel="stylesheet" href="../view/css/dmsanpham.css">
    <link rel="stylesheet" href="../view/css/chitietsanpham.css">
    <link rel="stylesheet" href="../view/css/lienhe.css">
    <link rel="stylesheet" href="../view/css/giohang.css">
    <link rel="stylesheet" href="../view/css/gioithieu.css">
    <link rel="stylesheet" href="../view/css/login.css">
    <link rel="stylesheet" href="../view/css/qsa.css">
    <link rel="stylesheet" href="../view/lib/themify-icons/themify-icons.css">
</head>

<body>
    <div class="main">
        <!-- Header -->
        <div class="header">
            <img src="../view/images/header/header-logo.png" alt="" class="logo">

            <ul class="navbar non-list">
                <li class="navbar-child"><a href="./index.php">Trang chủ</a></li>
                <li class="navbar-child nav-far">
                    <a href="">Danh mục <i class="ti-angle-down"></i></a>
                    <ul class="subnav non-list">
                        <li class="subnav-child"><a href="./index.php?act=dtt_dabong">Đồ thể thao đá bóng</a></li>
                        <li class="subnav-child"><a href="./index.php?act=dtt_caulong">Đồ thể thao cầu lông</a></li>
                        <li class="subnav-child"><a href="./index.php?act=dtt_bongro">Đồ thể thao bóng rổ</a></li>
                        <li class="subnav-child"><a href="./index.php?act=dtt_bongchuyen">Đồ thể thao bóng chuyền</a></li>
                        <li class="subnav-child"><a href="./index.php?act=phukien">Phụ kiện</a></li>
                    </ul>
                </li>
                <li class="navbar-child"><a href="./index.php?act=gioithieu">Giới thiệu</a></li>
                <li class="navbar-child"><a href="./index.php?act=lienhe">Liên hệ</a></li>
                <li class="navbar-child"><a href="./index.php?act=donhang">Đơn hàng của tôi</a></li>
                <li class="navbar-child"><a href="./index.php?act=qa">Hỏi đáp</a></li>
            </ul>

            <div class="header-right">
                <form class="frm-search">
                    <input class="search-nav" type="text" placeholder="Nhập tên sản phẩm">
                    <i class="ti-search search-icon"></i>
                </form>

                <!-- Cart -->
                <a href="./index.php?act=giohang" class="header-cart">
                    <i class="ti-shopping-cart"></i>
                        <?php if ($cart_count > 0): ?>
                        <span class="header-cart-count"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>
                <!-- Phần header-right, thay thế div account-sign -->
            <!-- Phần header-right, thay thế div account-sign -->
            <div class="account-sign">
                <i class="ti-user"></i>
                <p class="icon-text">
                    <?php
                    // Bắt đầu session nếu chưa có
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION['user']) && !empty($_SESSION['user']['full_name'])) {
                        $userName = htmlspecialchars($_SESSION['user']['full_name']); // Bảo mật XSS
                        // Đã đăng nhập
                        echo '<a style="text-decoration: none; color: black;" href="index.php?act=profile">'
                                . $userName .
                            '</a>';
                           
                    } else {
                        // Chưa đăng nhập
                        $url = "index.php?act=login&redirect=" . urlencode($_SERVER["REQUEST_URI"]);
                        echo '<a style="text-decoration: none; color: black;" href="' . $url . '">Tài khoản</a>';
                    }
                    ?>
                </p>
            </div>

        </div>
    </div>
        


        