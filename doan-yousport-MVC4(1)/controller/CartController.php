<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 🛒 Thêm vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = (float)$_POST['price'];
    $image = $_POST['image'];
    $quantity = (int)($_POST['quantity'] ?? 1);

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => $quantity
        ];
    }

    header("Location: ./index.php?act=giohang");
}

// ⚡ Mua ngay → Thêm và chuyển sang thanh toán
if (isset($_GET['action']) && $_GET['action'] === 'buynow') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = (float)$_POST['price'];
    $image = $_POST['image'];
    $quantity = (int)($_POST['quantity'] ?? 1);

    $_SESSION['cart'][$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'quantity' => $quantity
    ];

    header("Location: ./index.php?act=checkout");

    exit;

    header("Location: ../index.php?act=success");
    exit;
}
