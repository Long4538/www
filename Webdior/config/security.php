<?php
// CSRF token utilities
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function csrf_generate_token(string $form = 'default'): string {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_tokens'][$form] = $token;
    return $token;
}

function csrf_validate_token(?string $token, string $form = 'default'): bool {
    if (!$token) return false;
    $valid = isset($_SESSION['csrf_tokens'][$form]) && hash_equals($_SESSION['csrf_tokens'][$form], $token);
    // one-time token
    unset($_SESSION['csrf_tokens'][$form]);
    return $valid;
}


