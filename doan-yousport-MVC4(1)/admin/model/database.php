<?php
// admin/model/database.php
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=webshop;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connect error: " . $e->getMessage());
}
