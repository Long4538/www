<?php 
session_start();
$base_url = '/Webdior';
if (!isset($_SESSION['user_id'])) { header('Location: ' . $base_url . '/page/dang-nhap.php'); exit; }
$page_title = 'Thanh toán | Webdior';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/security.php';

// Lấy thông tin user nếu đã đăng nhập để prefill
$user = null;
if (isset($_SESSION['user_id'])) {
	$user = fetchOne("SELECT first_name, last_name, email, phone, address, city, district, ward FROM users WHERE id = ?", [$_SESSION['user_id']]);
}
$csrf_checkout = csrf_generate_token('checkout');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include '../includes/head.php'; ?>
</head>
<body class="bg-light">
    <?php include '../includes/header.php'; ?>

    <main class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/Webdior/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/Webdior/page/gio-hang.php">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                </ol>
            </nav>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h5 class="mb-3">Thông tin giao hàng</h5>
                        <?php if (!empty($_SESSION['checkout_errors'])): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($_SESSION['checkout_errors'] as $error): ?>
                                    <div><?php echo htmlspecialchars($error); ?></div>
                                <?php endforeach; unset($_SESSION['checkout_errors']); ?>
                            </div>
                        <?php endif; ?>
                        <form action="/Webdior/checkout-process.php" method="POST" class="row g-3">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_checkout); ?>">
                            <div class="col-md-6">
                                <label class="form-label">Họ</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ($_SESSION['user_email'] ?? '')); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tỉnh/Thành</label>
                                <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quận/Huyện</label>
                                <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($user['district'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phường/Xã</label>
                                <input type="text" name="ward" class="form-control" value="<?php echo htmlspecialchars($user['ward'] ?? ''); ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select name="payment_method" class="form-select">
                                    <option value="cod">COD - Thanh toán khi nhận hàng</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Đặt hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h5 class="mb-3">Đơn hàng của bạn</h5>
                        <div id="checkout-summary"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
    <script>
    function fmt(v){return new Intl.NumberFormat('vi-VN').format(v)+' \u20AB'}
    function loadSummary(){
        fetch('/Webdior/api/cart-get.php').then(r=>r.json()).then(data=>{
            const wrap=document.getElementById('checkout-summary');
            if(!data.items || data.items.length===0){
                wrap.innerHTML='<div class="text-muted">Giỏ hàng trống.</div>';
            } else {
                wrap.innerHTML = `
                    <div class="vstack gap-2">
                        ${data.items.map(i=>`<div class="d-flex justify-content-between"><span>${i.name} x ${i.quantity}</span><strong>${fmt(i.total)}</strong></div>`).join('')}
                        <hr>
                        <div class="d-flex justify-content-between"><span>Tạm tính</span><strong>${fmt(data.subtotal)}</strong></div>
                        <div class="d-flex justify-content-between"><span>Phí vận chuyển</span><strong>${fmt(data.shipping)}</strong></div>
                        <div class="d-flex justify-content-between"><span>Tổng cộng</span><strong>${fmt(data.grand_total)}</strong></div>
                    </div>`;
            }
        });
    }
    loadSummary();
    </script>
</body>
</html>


