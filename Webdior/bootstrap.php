<?php
// Bootstrap khởi tạo cho mọi entry point
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đọc env
$__env = require __DIR__ . '/config/env.php';

// Hằng số toàn cục
if (!defined('BASE_URL')) define('BASE_URL', $__env['BASE_URL']);
if (!defined('ASSETS_CSS')) define('ASSETS_CSS', $__env['ASSETS']['CSS']);
if (!defined('ASSETS_JS')) define('ASSETS_JS', $__env['ASSETS']['JS']);
if (!defined('ASSETS_IMG')) define('ASSETS_IMG', $__env['ASSETS']['IMG']);

unset($__env);


