<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$email = trim($_GET['email'] ?? '');
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'exists' => false, 'error' => 'Email không hợp lệ']);
    exit;
}

$user = fetchOne("SELECT id FROM users WHERE email = ? AND is_active = 1", [$email]);
echo json_encode(['success' => true, 'exists' => (bool)$user]);
?>


