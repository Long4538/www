<?php
require_once "database.php";

class ProductModel extends Database
{
    // ✅ Thêm bình luận
    public function addReview($product_id, $user_id, $rating, $comment)
    {
        try {
            $sql = "INSERT INTO reviews (product_id, user_id, rating, comment, created_at)
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$product_id, $user_id, $rating, $comment]);
        } catch (PDOException $e) {
            echo "<!-- DEBUG ADD REVIEW: " . $e->getMessage() . " -->";
        }
    }

    // ✅ Lấy bình luận có tên người dùng
    public function getReviewsByProduct($product_id)
    {
        $sql = "SELECT r.review_id, r.rating, r.comment AS content, r.created_at, 
                       u.full_name AS username
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                WHERE r.product_id = ?
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Lấy sản phẩm theo catalog_id (có giới hạn số lượng)
    public function getProductsByCatalog($catalog_id, $limit = 4)
    {
        $sql = "SELECT * FROM products WHERE catalog_id = :catalog_id LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':catalog_id', $catalog_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Lấy chi tiết sản phẩm theo id
    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // // ✅ Lấy danh sách review cho 1 sản phẩm
    // public function getReviewsByProduct($product_id)
    // {
    //     $sql = "SELECT r.review_id, r.rating, r.comment, r.created_at, 
    //                u.full_name
    //         FROM reviews r
    //         JOIN users u ON r.user_id = u.user_id
    //         WHERE r.product_id = :product_id
    //         ORDER BY r.created_at DESC";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }



    // // ✅ Thêm bình luận mới cho sản phẩm
    // public function addReview($product_id, $user_id, $rating, $comment)
    // {
    //     $sql = "INSERT INTO reviews (product_id, user_id, rating, comment, created_at)
    //             VALUES (:product_id, :user_id, :rating, :comment, NOW())";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    //     $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    //     $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
    //     $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    //     return $stmt->execute();
    // }



    
}
