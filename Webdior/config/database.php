<?php
/**
 * CẤU HÌNH KẾT NỐI CƠ SỞ DỮ LIỆU
 * 
 * File này chứa cấu hình kết nối đến MySQL database
 * cho trang web bán nước hoa DIOR
 */

// Cấu hình database
define('DB_HOST', 'localhost');
define('DB_NAME', 'dior_perfume_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Cấu hình PDO options
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
];

/**
 * Hàm kết nối database
 * @return PDO
 */
function getDBConnection() {
    global $pdo_options;
    
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $pdo_options);
        return $pdo;
    } catch (PDOException $e) {
        // Log lỗi (trong production nên log vào file)
        error_log("Database connection failed: " . $e->getMessage());
        
        // Hiển thị lỗi thân thiện với user
        die("Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.");
    }
}

/**
 * Hàm test kết nối database
 * @return bool
 */
function testDBConnection() {
    try {
        $pdo = getDBConnection();
        return $pdo !== null;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Hàm thực thi query với prepared statement
 * @param string $sql
 * @param array $params
 * @return PDOStatement
 */
function executeQuery($sql, $params = []) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Hàm lấy một bản ghi
 * @param string $sql
 * @param array $params
 * @return array|false
 */
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

/**
 * Hàm lấy nhiều bản ghi
 * @param string $sql
 * @param array $params
 * @return array
 */
function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

/**
 * Hàm đếm số bản ghi
 * @param string $sql
 * @param array $params
 * @return int
 */
function countRecords($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->rowCount();
}

/**
 * Hàm insert và trả về ID mới
 * @param string $sql
 * @param array $params
 * @return int
 */
function insertAndGetId($sql, $params = []) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $pdo->lastInsertId();
}

/**
 * Hàm bắt đầu transaction
 * @return PDO
 */
function beginTransaction() {
    $pdo = getDBConnection();
    $pdo->beginTransaction();
    return $pdo;
}

/**
 * Hàm commit transaction
 * @param PDO $pdo
 */
function commitTransaction($pdo) {
    $pdo->commit();
}

/**
 * Hàm rollback transaction
 * @param PDO $pdo
 */
function rollbackTransaction($pdo) {
    $pdo->rollback();
}

// Test kết nối khi load file
if (!testDBConnection()) {
    // Có thể redirect đến trang lỗi hoặc hiển thị thông báo
    // header('Location: /error/database.php');
}
?>
