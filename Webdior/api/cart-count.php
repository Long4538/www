<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
	echo json_encode(['success' => true, 'count' => 0]);
	exit;
}

$row = fetchOne("SELECT SUM(quantity) AS cnt FROM cart_items WHERE user_id = ?", [$userId]);
$count = (int)($row['cnt'] ?? 0);
echo json_encode(['success' => true, 'count' => $count]);


