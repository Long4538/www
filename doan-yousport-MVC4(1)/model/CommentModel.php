<?php
require_once __DIR__ . "/database.php";

class CommentModel extends Database
{
    public function getCommentsByProduct($product_id)
    {
        try {
            // DEBUG: Kiểm tra kết nối
            if (!$this->conn) {
                echo "<!-- DEBUG: Database connection is NULL -->";
                return [];
            }

            $sql = "SELECT r.review_id, r.rating, r.comment AS content, r.created_at, u.full_name AS username
                    FROM reviews r 
                    JOIN users u ON r.user_id = u.user_id 
                    WHERE r.product_id = ?
                    ORDER BY r.created_at DESC";  // ✅ Thêm ORDER BY để comment mới nhất lên đầu

            $stmt = $this->conn->prepare($sql);
            $execute_result = $stmt->execute([$product_id]);

            if (!$execute_result) {
                $error_info = $stmt->errorInfo();
                echo "<!-- DEBUG: SELECT EXECUTE FAILED: " . print_r($error_info, true) . " -->";
                return [];
            }

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                echo "<!-- DEBUG: SUCCESS - Found " . count($result) . " comments -->";
                foreach ($result as $comment) {
                    echo "<!-- DEBUG Comment: " . $comment['username'] . " - " . $comment['content'] . " -->";
                }
            } else {
                echo "<!-- DEBUG: No comments found -->";
            }

            return $result;
        } catch (PDOException $e) {
            echo "<!-- DEBUG: PDO Exception in SELECT: " . $e->getMessage() . " -->";
            return [];
        }
    }

    public function addComment($product_id, $user_id, $content, $rating = 5)
    {
        try {
            // ✅ Bắt đầu transaction để đảm bảo atomicity
            $this->conn->beginTransaction();

            $sql = "INSERT INTO reviews (product_id, user_id, rating, comment, created_at)
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $execute_result = $stmt->execute([$product_id, $user_id, $rating, $content]);

            if (!$execute_result) {
                $error_info = $stmt->errorInfo();
                echo "<!-- DEBUG: INSERT EXECUTE FAILED: " . print_r($error_info, true) . " -->";
                $this->conn->rollBack();
                return ['success' => false, 'error' => $error_info[2]];  // Return error message
            }

            $row_count = $stmt->rowCount();
            if ($row_count === 0) {
                echo "<!-- DEBUG: INSERT rowCount=0 - No rows affected -->";
                $this->conn->rollBack();
                return ['success' => false, 'error' => 'No rows inserted'];
            }

            // Commit transaction
            $this->conn->commit();
            echo "<!-- DEBUG: INSERT SUCCESS - rowCount=" . $row_count . " -->";

            return ['success' => true];  // Return array để controller xử lý
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "<!-- DEBUG: INSERT PDO Exception: " . $e->getMessage() . " -->";
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}