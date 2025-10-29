<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu giỏ hàng chưa tồn tại thì tạo rỗng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // sắp lại chỉ số
            break;
        }
    }

    // Quay lại đúng route MVC
    header("Location: ../controller/index.php?act=giohang");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>

<!-- Thêm Font Awesome để hiển thị icon thùng rác -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../view/css/giohang.css">

<div class="cart-page">
    <div class="cart__container fade-in">
        <h2 class="cart__title">🛒 Giỏ hàng của bạn</h2>

        <?php if (empty($cart)) { ?>
            <p class="cart__empty">Giỏ hàng của bạn đang trống!</p>
            <a href="../controller/index.php" class="cart__btn cart__btn-continue glow-btn">🛍 Tiếp tục mua hàng</a>
        <?php } else { ?>
            <table class="cart__table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tạm tính</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tong = 0;
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $tong += $subtotal;
                    ?>
                    <tr>
                        <td><img src="../view/images/products/<?= htmlspecialchars($item['image']) ?>" class="cart__img"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price']) ?>đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($subtotal) ?>đ</td>
                        <td>
                            <a href="../controller/index.php?act=giohang&remove=<?= $item['id'] ?>" 
                               class="cart__remove"
                               title="Xóa sản phẩm"
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng không?');">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="cart__total-label">Tổng cộng:</td>
                        <td class="cart__total-value" colspan="2"><?= number_format($tong) ?>đ</td>
                    </tr>
                </tbody>
            </table>

            <div class="cart__actions">
                <a href="../controller/index.php" class="cart__btn cart__btn-continue glow-btn">🛍 Tiếp tục mua</a>
                <a href="../controller/index.php?act=checkout" class="cart__btn cart__btn-checkout glow-btn">💳 Thanh toán</a>
            </div>
        <?php } ?>
    </div>
</div>
