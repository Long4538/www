<?php
function pdo_get_connection() {
    $servername = "localhost";
    $dbname = "webshop"; // ⚠️ Đổi tên đúng CSDL bạn đang dùng
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

function pdo_query($sql, ...$params) {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $rows;
}

function pdo_query_one($sql, ...$params) {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $row;
}

function pdo_execute($sql, ...$params) {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $conn = null;
}
?>
