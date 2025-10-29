<?php 
session_start();
$page_title = 'Tài khoản | Webdior';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/security.php';

// Nếu chưa đăng nhập, chuyển sang trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: /Webdior/page/dang-nhap.php');
    exit;
}

$base_url = '/Webdior';
$userId = $_SESSION['user_id'];
// Lấy thông tin user từ DB để hiển thị và chỉnh sửa
$user = fetchOne("SELECT email, first_name, last_name, phone, address, city, district, ward FROM users WHERE id = ?", [$userId]) ?: [];
$userEmail = $user['email'] ?? ($_SESSION['user_email'] ?? '');
$firstName = $user['first_name'] ?? '';
$lastName = $user['last_name'] ?? '';
$userName = trim(($firstName . ' ' . $lastName)) ?: ($userEmail ?: 'Tài khoản');
$isAdmin = !empty($_SESSION['is_admin']);

// Tạo CSRF cho form cập nhật
$csrf_update = csrf_generate_token('update_profile');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include '../includes/head.php'; ?>
    <style>
        .account-card { border: 1px solid #eaeaea; border-radius: 8px; }
        .account-nav a { text-decoration: none; }
        .account-nav .active { font-weight: 600; }
    </style>
    </head>
<body class="bg-light">
    <?php include '../includes/header.php'; ?>

    <main class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>/">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                </ol>
            </nav>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="account-card bg-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-bold"><?php echo htmlspecialchars($userName); ?></div>
                                <div class="text-muted small"><?php echo htmlspecialchars($userEmail); ?></div>
                            </div>
                        </div>
                        <hr>
                        <div class="account-nav d-grid gap-2">
                            <a href="#" class="text-dark active"><i class="fas fa-user me-2"></i>Thông tin tài khoản</a>
                            <a href="<?php echo $base_url; ?>/page/don-hang.php" class="text-dark"><i class="fas fa-box me-2"></i>Đơn hàng của tôi</a>
                            <?php if ($isAdmin): ?>
                            <a href="<?php echo $base_url; ?>/admin/products.php" class="text-dark"><i class="fas fa-tools me-2"></i>Trang quản trị</a>
                            <?php endif; ?>
                            <a href="<?php echo $base_url; ?>/page/doi-mat-khau.php" class="text-dark"><i class="fas fa-key me-2"></i>Đổi mật khẩu</a>
                            <a href="<?php echo $base_url; ?>/logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="account-card bg-white p-4">
                        <h5 class="mb-3">Chi tiết tài khoản</h5>
                        <?php if (!empty($_SESSION['account_errors'])): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($_SESSION['account_errors'] as $error): ?>
                                    <div><?php echo htmlspecialchars($error); ?></div>
                                <?php endforeach; unset($_SESSION['account_errors']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['account_success'])): ?>
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($_SESSION['account_success']); unset($_SESSION['account_success']); ?>
                            </div>
                        <?php endif; ?>
                        <?php $old = $_SESSION['account_data'] ?? []; unset($_SESSION['account_data']); ?>
                        <form action="<?php echo $base_url; ?>/update-profile-process.php" method="POST" class="row g-3">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_update); ?>">
                            <div class="col-md-6">
                                <label class="form-label">Họ</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($old['last_name'] ?? $lastName); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($old['first_name'] ?? $firstName); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($userEmail); ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($old['phone'] ?? ($user['phone'] ?? '')); ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($old['address'] ?? ($user['address'] ?? '')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tỉnh/Thành</label>
                                <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($old['city'] ?? ($user['city'] ?? '')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quận/Huyện</label>
                                <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($old['district'] ?? ($user['district'] ?? '')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phường/Xã</label>
                                <input type="text" name="ward" class="form-control" value="<?php echo htmlspecialchars($old['ward'] ?? ($user['ward'] ?? '')); ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
</body>
</html>


