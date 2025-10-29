<?php
session_start();
require_once 'config.php';

// ✅ Kiểm tra quyền admin
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($id > 0 && !empty($status)) {

        // ✅ Lấy thông tin đơn hàng để biết user nào đặt
        $stmt = $pdo->prepare("SELECT user_id, status FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            header("Location: orders.php?error=order_not_found");
            exit;
        }

        // ✅ Cập nhật trạng thái đơn hàng
        $update = $pdo->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $update->execute([$status, $id]);

        // ✅ Gửi thông báo cho user dựa theo trạng thái
        $message = null;
        if ($status === 'processing') {
            $message = "Đơn hàng #$id của bạn đã được xác nhận. Dự kiến giao hàng trong 2–3 ngày tới.";
        } elseif ($status === 'shipped') {
            $message = "Đơn hàng #$id của bạn đã được giao cho đơn vị vận chuyển. Vui lòng chú ý điện thoại để nhận hàng.";
        } elseif ($status === 'paid') {
            $message = "Đơn hàng #$id đã được thanh toán thành công. Cảm ơn bạn đã mua sắm!";
        } elseif ($status === 'completed') {
            $message = "Đơn hàng #$id của bạn đã hoàn tất. Cảm ơn bạn đã mua sắm tại Nước Hoa DA!";
        } elseif ($status === 'cancelled') {
            $message = "Đơn hàng #$id của bạn đã bị hủy. Vui lòng liên hệ với chúng tôi nếu cần hỗ trợ thêm.";
        }

        // ✅ Ghi thông báo vào bảng notifications nếu có message
        if ($message) {
            $notify = $pdo->prepare("
                INSERT INTO notifications (user_id, order_id, message, is_read, created_at)
                VALUES (?, ?, ?, 0, NOW())
            ");
            $notify->execute([$order['user_id'], $id, $message]);
        }

        // ✅ Quay lại trang danh sách đơn hàng với thông báo thành công
        header("Location: orders.php?updated=1&id=$id");
        exit;
    }
}

// ❌ Nếu request không hợp lệ
header("Location: orders.php?error=invalid_request");
exit;
?>
