<?php
if (!isset($user)) {
    echo "<p>Không tìm thấy thông tin người dùng.</p>";
    exit;
}

$full_name = htmlspecialchars($user['full_name']);
$email = htmlspecialchars($user['email']);
$phone = htmlspecialchars($user['phone'] ?? '');
$dob = htmlspecialchars($user['dob'] ?? '');
$address = htmlspecialchars($user['address'] ?? '');
$initials = strtoupper(substr($full_name, 0, 1)); // Lấy ký tự đầu tên
?>
<link rel="stylesheet" href="../view/css/profile.css">

<div class="profile-wrapper">
    <!-- Cột trái -->
    <div class="profile-sidebar">
        <div class="avatar">
            <div class="avatar-circle"><?= $initials ?></div>
        </div>
        <h3>Xin chào <span class="name"><?= $full_name ?></span></h3>

        <ul class="profile-menu">
            <li><i class="ti-user"></i> <a href="#">Thông tin tài khoản</a></li>
            <li><i class="ti-receipt"></i> <a href="index.php?act=donhang">Quản lý đơn hàng</a></li>
            <li><i class="ti-location-pin"></i> <a href="#">Danh sách địa chỉ</a></li>
            <li><i class="ti-shift-right"></i> <a href="index.php?act=logout" style="color:red;">Đăng xuất</a></li>
        </ul>
    </div>

    <!-- Cột phải -->
    <div class="profile-content">
        <h2>THÔNG TIN TÀI KHOẢN</h2>
        <p><strong>Họ và tên:</strong> <?= $full_name ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <p><strong>Địa chỉ:</strong> <?= $address ?: 'Chưa cập nhật' ?></p>
        <p><strong>Ngày sinh:</strong> <?= $dob ?: 'Chưa cập nhật' ?></p>
        <p><strong>Điện thoại:</strong> <?= $phone ?: 'Chưa cập nhật' ?></p>

        <div class="membership-box">
            <p><strong>Hạng thẻ tiếp theo:</strong> Silver - chiết khấu 3% membership</p>
            <a href="#">Xem thêm chính sách khách hàng thân thiết.</a>
        </div>
    </div>
</div>
