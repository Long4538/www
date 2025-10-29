<?php 
session_start();
$page_title = 'Đơn hàng của tôi | Webdior';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
	header('Location: /Webdior/page/dang-nhap.php');
	exit;
}

$userId = $_SESSION['user_id'];
$orders = fetchAll("SELECT id, order_number, total_amount, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC", [$userId]);
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
                    <li class="breadcrumb-item active" aria-current="page">Đơn hàng của tôi</li>
                </ol>
            </nav>
            <div class="bg-white p-4 shadow-sm rounded-3">
                <h5 class="mb-3">Đơn hàng của tôi</h5>
                <?php if (!$orders): ?>
                    <div class="text-muted">Bạn chưa có đơn hàng nào.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($o['order_number']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($o['created_at']))); ?></td>
                                        <td><span class="badge bg-secondary text-capitalize"><?php echo htmlspecialchars($o['status']); ?></span></td>
                                        <td class="text-end"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?> ₫</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
    <?php include '../includes/scripts.php'; ?>
</body>
</html>


