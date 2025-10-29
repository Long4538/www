<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../model/Database.php";
$db = new Database();
$conn = $db->getConnection();

$cart = $_SESSION['cart'] ?? [];

// Nếu giỏ hàng trống, quay lại
if (count($cart) == 0) {
    header("Location: giohang.php");
    exit;
}

// Tính tổng tiền
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
$final = max(0, $total);

// Lấy user đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để đặt hàng!'); window.location.href='../controller/index.php?act=login';</script>";
    exit;
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $note = trim($_POST['note']);

    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // 1️⃣ Thêm vào bảng transactions (có cả thông tin nhận hàng)
        $sqlTrans = "INSERT INTO transactions (user_id, name, phone, address, note, total_amount, payment_method, status, created_at)
                     VALUES (?, ?, ?, ?, ?, ?, 'COD', 'pending', NOW())";
        $stmt = $conn->prepare($sqlTrans);
        $stmt->execute([$user_id, $name, $phone, $address, $note, $final]);

        // Lấy ID đơn hàng mới
        $transaction_id = $conn->lastInsertId();

        // 2️⃣ Thêm chi tiết sản phẩm vào bảng orders
        $sqlOrder = "INSERT INTO orders (transaction_id, product_id, quantity, price)
                     VALUES (?, ?, ?, ?)";
        $stmtOrder = $conn->prepare($sqlOrder);

        foreach ($cart as $item) {
            $stmtOrder->execute([$transaction_id, $item['id'], $item['quantity'], $item['price']]);
        }

        // Commit
        $conn->commit();

        // 3️⃣ Lưu thông tin vào session
        $_SESSION['order_info'] = [
            'id' => $transaction_id,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'note' => $note,
            'total' => $final
        ];

        // 4️⃣ Xóa giỏ hàng
        unset($_SESSION['cart']);

        // 5️⃣ Chuyển đến trang thành công
        header("Location: ../controller/index.php?act=success");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        echo "<script>alert('Lỗi khi lưu đơn hàng: " . $e->getMessage() . "');</script>";
    }
}
?>

<link rel="stylesheet" href="../view/css/checkout.css">

<div class="checkout__container fade-in">
    <h2 class="checkout__title">Thông tin đặt hàng</h2>

    <form method="POST" class="checkout__form">
        <div class="checkout__group">
            <label for="name" class="checkout__label">Họ và tên:</label>
            <input type="text" id="name" name="name" class="checkout__input" required>
        </div>

        <div class="checkout__group">
            <label for="phone" class="checkout__label">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="checkout__input" required>
        </div>

        <div class="checkout__group">
            <label for="address" class="checkout__label">Địa chỉ giao hàng:</label>
            <textarea id="address" name="address" class="checkout__textarea" required></textarea>
        </div>

        <div class="checkout__group">
            <label for="note" class="checkout__label">Ghi chú:</label>
            <textarea id="note" name="note" class="checkout__textarea"></textarea>
        </div>

        <div class="checkout__summary">
            <span class="checkout__total-label">Tổng tiền thanh toán:</span>
            <span class="checkout__total-value"><?= number_format($final) ?>đ</span>
        </div>

        <div class="checkout__actions">
            <button type="submit" class="checkout__btn glow-btn">Xác nhận đặt hàng</button>
        </div>
    </form>
</div>
