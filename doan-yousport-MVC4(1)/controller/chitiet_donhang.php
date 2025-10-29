<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../model/Database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_GET['id'])) {
    header("Location: ../view/pages/donhang.php");
    exit;
}

$transaction_id = (int)$_GET['id'];

// Lấy thông tin đơn hàng
$sql = "SELECT t.*, u.full_name, u.email
        FROM transactions t
        JOIN users u ON t.user_id = u.user_id
        WHERE t.transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$transaction_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<p>Không tìm thấy đơn hàng!</p>";
    exit;
}

// Lấy sản phẩm trong đơn
$sql = "SELECT p.name, p.image_main, o.quantity, o.price, (o.quantity * o.price) AS subtotal
        FROM orders o
        JOIN products p ON o.product_id = p.product_id
        WHERE o.transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$transaction_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../view/css/order_detail.css">

<div class="order-detail-page fade-in">
    <div class="order-detail-container">
        <h2 class="order-detail-title">🧾 Chi tiết đơn hàng #<?= $order['transaction_id'] ?></h2>

        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
        <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
        <p><strong>Trạng thái:</strong> 
            <span style="color: <?= $order['status'] === 'pending' ? 'orange' : ($order['status'] === 'paid' ? 'green' : 'red') ?>; font-weight:bold;">
                <?= ucfirst($order['status']) ?>
            </span>
        </p>

        <table class="order-detail-table">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tong = 0;
                foreach ($items as $item):
                    $tong += $item['subtotal'];
                ?>
                <tr>
                    <td><img src="../view/images/products/<?= $item['image_main'] ?>" class="order-detail__img"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price']) ?>đ</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['subtotal']) ?>đ</td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="4" align="right"><strong>Tổng cộng:</strong></td>
                    <td><strong><?= number_format($tong) ?>đ</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="order-detail-actions">
            <a href="../controller/index.php?act=donhang" class="btn btn-view">← Quay lại danh sách đơn hàng</a>
        </div>
    </div>
</div>
