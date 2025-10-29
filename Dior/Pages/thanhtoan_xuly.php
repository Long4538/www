<?php
session_start();
require '../admincp/config.php';

// ✅ 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_name'])) {
    header("Location: dangnhap.php");
    exit;
}

// ✅ 2. Lấy user_id từ session
$user_id = $_SESSION['user_id'] ?? null;

// ✅ 3. Kiểm tra phương thức gửi form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: thanhtoan.php");
    exit;
}

// ✅ 4. Nhận dữ liệu từ form
$fullname   = trim($_POST['fullname']);
$phone      = trim($_POST['phone']);
$address    = trim($_POST['address']);
$payment    = trim($_POST['payment']);
$product_id = $_POST['product_id'] ?? null;

// ✅ 5. Lấy giỏ hàng (nếu có)
$cart = $_SESSION['cart'] ?? [];

// ✅ 6. Xác định danh sách sản phẩm cần lưu
$order_items = [];

if ($product_id) {
    // 🟢 Mua ngay
    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $order_items[] = [
            'id'       => $product['id'],
            'name'     => $product['name'],
            'price'    => $product['price'],
            'quantity' => 1
        ];
    }
} else {
    // 🟣 Thanh toán giỏ hàng
    foreach ($cart as $item) {
        $order_items[] = [
            'id'       => $item['id'],
            'name'     => $item['name'],
            'price'    => $item['price'],
            'quantity' => $item['quantity']
        ];
    }
}

// ✅ 7. Tính tổng tiền
$total_amount = 0;
foreach ($order_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// ✅ 8. Giao dịch DB để đảm bảo toàn vẹn dữ liệu
try {
    $pdo->beginTransaction();

    // 🧾 Lưu đơn hàng vào bảng orders
    // 🧾 Tạo mã đơn hàng ngẫu nhiên và duy nhất
$order_number = 'ORD' . date('YmdHis') . rand(1000, 9999);

$stmt = $pdo->prepare("
    INSERT INTO orders (user_id, order_number, shipping_address, billing_address, payment_method, total, status, created_at)
    VALUES (:user_id, :order_number, :shipping_address, :billing_address, :payment_method, :total, :status, NOW())
");
$stmt->execute([
    ':user_id' => $user_id,
    ':order_number' => $order_number,
    ':shipping_address' => $address,
    ':billing_address' => $address,
    ':payment_method' => $payment,
    ':total' => $total_amount,
    ':status' => 'pending'
]);


    // 🔹 Lấy ID đơn hàng vừa tạo
    $order_id = $pdo->lastInsertId();

    // 🧩 Dò cấu trúc bảng order_items (để tránh lỗi cột 'price')
    $colsStmt = $pdo->query("SHOW COLUMNS FROM order_items");
    $cols = $colsStmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Các tên cột giá có thể có
    $possiblePriceNames = ['price','unit_price','amount','item_price','product_price','total_price'];
    $priceCol = null;
    foreach ($possiblePriceNames as $pn) {
        if (in_array($pn, $cols, true)) {
            $priceCol = $pn;
            break;
        }
    }

    // Tạo câu SQL động theo cột thực tế
    $insertCols = ['order_id','product_id','product_name','quantity'];
    $placeholders = [':order_id',':pid',':pname',':qty'];
    if ($priceCol) {
        $insertCols[] = $priceCol;
        $placeholders[] = ':price';
    }

    $sql = "INSERT INTO order_items (" . implode(',', $insertCols) . ") VALUES (" . implode(',', $placeholders) . ")";
    $item_stmt = $pdo->prepare($sql);

    // 🛒 Lưu từng sản phẩm
    foreach ($order_items as $item) {
        $params = [
            ':order_id' => $order_id,
            ':pid'      => $item['id'],
            ':pname'    => $item['name'],
            ':qty'      => $item['quantity'],
        ];
        if ($priceCol) {
            $params[':price'] = $item['price'];
        }
        $item_stmt->execute($params);
    }

    // 🧹 Xóa giỏ hàng
    unset($_SESSION['cart']);

    // ✅ Hoàn tất giao dịch
    $pdo->commit();

    // 🔁 Chuyển hướng sang trang thành công
    header("Location: dathang_thanhcong.php?order_id=" . $order_id);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<h3 style='color:red; text-align:center;'>❌ Lỗi khi xử lý đơn hàng: " . htmlspecialchars($e->getMessage()) . "</h3>";
}
?>
