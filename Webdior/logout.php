<?php
/**
 * Xử lý đăng xuất
 */

session_start();

// Xóa tất cả session
session_destroy();

// Redirect về trang đăng nhập
header('Location: /Webdior/page/dang-nhap.php');
exit;
?>
