<?php
// view/pages/donhang.php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../model/Database.php";
$db = new Database();
$conn = $db->getConnection();

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem đơn hàng!'); window.location.href='../controller/index.php?act=login';</script>";
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// 🗑 HỦY ĐƠN HÀNG (XÓA THẬT)
if (isset($_GET['delete'])) {
    $transaction_id = (int)$_GET['delete'];

    // Kiểm tra đơn có thuộc người này không
    $check = $conn->prepare("SELECT * FROM transactions WHERE transaction_id = ? AND user_id = ?");
    $check->execute([$transaction_id, $user_id]);

    if ($check->rowCount() > 0) {
        try {
            $conn->beginTransaction();

            // Xóa chi tiết đơn hàng (orders)
            $stmt1 = $conn->prepare("DELETE FROM orders WHERE transaction_id = ?");
            $stmt1->execute([$transaction_id]);

            // Xóa đơn chính (transactions)
            $stmt2 = $conn->prepare("DELETE FROM transactions WHERE transaction_id = ?");
            $stmt2->execute([$transaction_id]);

            $conn->commit();

            $_SESSION['cancel_success'] = "✅ Đã xóa đơn hàng #$transaction_id thành công.";
            header("Location: ../controller/index.php?act=donhang");
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            $_SESSION['cancel_error'] = "❌ Lỗi khi xóa đơn hàng: " . $e->getMessage();
            header("Location: ../controller/index.php?act=donhang");
            exit;
        }
    } else {
        $_SESSION['cancel_error'] = "⚠️ Không thể xóa đơn hàng này!";
        header("Location: ../controller/index.php?act=donhang");
        exit;
    }
}

// 📦 Lấy danh sách đơn hàng
$sql = "SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../view/css/orders.css">

<div class="orders-page fade-in">
    <div class="orders-container">
        <h2 class="orders-title">📦 Danh sách đơn hàng của bạn</h2>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($_SESSION['cancel_success'])): ?>
            <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                <?= htmlspecialchars($_SESSION['cancel_success']) ?>
            </div>
            <?php unset($_SESSION['cancel_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['cancel_error'])): ?>
            <div style="color: red; font-weight: bold; margin-bottom: 10px;">
                <?= htmlspecialchars($_SESSION['cancel_error']) ?>
            </div>
            <?php unset($_SESSION['cancel_error']); ?>
        <?php endif; ?>

        <?php if (empty($orders)) { ?>
            <p class="orders-empty">Bạn chưa có đơn hàng nào.</p>
            <a href="../controller/index.php" class="btn btn-view">← Tiếp tục mua hàng</a>
        <?php } else { ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['transaction_id'] ?></td>
                        <td><?= htmlspecialchars($order['name']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        <td><?= number_format($order['total_amount']) ?>đ</td>
                        <td><?= strtoupper($order['payment_method']) ?></td>
                        <td>
                            <?php
                                $color = match($order['status']) {
                                    'pending' => 'orange',
                                    'paid' => 'green',
                                    'cancelled' => 'red',
                                    default => 'gray'
                                };
                            ?>
                            <span style="color:<?= $color ?>; font-weight:bold;">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="../controller/chitiet_donhang.php?id=<?= $order['transaction_id'] ?>" class="btn btn-view">👁 Xem</a>
                            <?php if ($order['status'] === 'pending'): ?>
                                <a href="../controller/index.php?act=donhang&delete=<?= $order['transaction_id'] ?>" 
                                   class="btn btn-delete"
                                   onclick="return confirm('Bạn có chắc muốn xóa hoàn toàn đơn hàng này không?');">
                                   ❌ Hủy
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<?php ob_end_flush(); ?>
