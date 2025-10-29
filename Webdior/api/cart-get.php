<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
	header('HTTP/1.1 401 Unauthorized');
	echo json_encode(['success' => false, 'requires_login' => true]);
	exit;
}

$rows = fetchAll(
	"SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, p.sale_price, p.main_image
	 FROM cart_items ci
	 JOIN products p ON p.id = ci.product_id
	 WHERE ci.user_id = ?
	 ORDER BY ci.created_at DESC",
	[$userId]
);

$items = [];
$subtotal = 0;
foreach ($rows as $r) {
	$unit = $r['sale_price'] !== null && $r['sale_price'] !== '' ? (float)$r['sale_price'] : (float)$r['price'];
	$total = $unit * (int)$r['quantity'];
	$subtotal += $total;
	$items[] = [
		'id' => (int)$r['id'],
		'product_id' => (int)$r['product_id'],
		'name' => $r['name'],
		'image' => $r['main_image'],
		'price' => $unit,
		'quantity' => (int)$r['quantity'],
		'total' => $total,
	];
}

// Shipping config
$shippingRow = fetchOne("SELECT setting_value FROM settings WHERE setting_key = 'shipping_fee'");
$freeRow = fetchOne("SELECT setting_value FROM settings WHERE setting_key = 'free_shipping_threshold'");
$shipping = (float)($shippingRow['setting_value'] ?? 0);
$freeThreshold = (float)($freeRow['setting_value'] ?? 0);
if ($freeThreshold > 0 && $subtotal >= $freeThreshold) {
	$shipping = 0;
}

$grand = $subtotal + $shipping;

echo json_encode([
	'success' => true,
	'items' => $items,
	'subtotal' => $subtotal,
	'shipping' => $shipping,
	'grand_total' => $grand,
]);


