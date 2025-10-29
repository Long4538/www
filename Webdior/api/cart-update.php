<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/security.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo json_encode(['success' => false, 'message' => 'Method not allowed']);
	exit;
}

$csrf = $_POST['csrf_token'] ?? null;
if (!csrf_validate_token($csrf, 'cart')) {
	echo json_encode(['success' => false, 'message' => 'CSRF invalid']);
	exit;
}

$itemId = (int)($_POST['item_id'] ?? 0);
$quantity = max(0, (int)($_POST['quantity'] ?? 1));
if ($itemId <= 0) {
	echo json_encode(['success' => false, 'message' => 'Thiếu item_id']);
	exit;
}

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
	echo json_encode(['success' => false, 'requires_login' => true]);
	exit;
}

try {
	$exists = fetchOne("SELECT id FROM cart_items WHERE id = ? AND user_id = ?", [$itemId, $userId]);
	if (!$exists) {
		echo json_encode(['success' => false, 'message' => 'Không tìm thấy mục giỏ hàng']);
		exit;
	}
	if ($quantity === 0) {
		executeStatement("DELETE FROM cart_items WHERE id = ?", [$itemId]);
	} else {
		executeStatement("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?", [$quantity, $itemId]);
	}
	echo json_encode(['success' => true]);
} catch (Exception $e) {
	echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống']);
}


