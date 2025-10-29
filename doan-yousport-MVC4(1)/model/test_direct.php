<?php
// test_comment_model.php
echo "<h1>Test CommentModel Independently</h1>";

require_once "model/database.php";
require_once "model/CommentModel.php";

// Test với product_id = 1
$product_id = 1;

echo "<h2>Testing CommentModel for product_id: $product_id</h2>";

$commentModel = new CommentModel();

echo "<h3>1. Testing getCommentsByProduct()</h3>";
$comments = $commentModel->getCommentsByProduct($product_id);

echo "<p><strong>Result count:</strong> " . count($comments) . "</p>";

if (!empty($comments)) {
    echo "<h4>Comments found:</h4>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>ID</th><th>User</th><th>Rating</th><th>Comment</th><th>Date</th></tr>";
    foreach ($comments as $comment) {
        echo "<tr>";
        echo "<td>" . $comment['review_id'] . "</td>";
        echo "<td>" . $comment['username'] . "</td>";
        echo "<td>" . $comment['rating'] . " ⭐</td>";
        echo "<td>" . $comment['content'] . "</td>";
        echo "<td>" . $comment['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red;'>No comments returned from model!</p>";
    
    // Test database trực tiếp
    echo "<h3>2. Testing direct database query</h3>";
    try {
        $db = new PDO("mysql:host=localhost;dbname=webshop", "root", "");
        $stmt = $db->prepare("SELECT * FROM reviews WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $direct_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p>Direct query found: " . count($direct_results) . " reviews</p>";
        if (!empty($direct_results)) {
            echo "<pre>";
            print_r($direct_results);
            echo "</pre>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>Direct query error: " . $e->getMessage() . "</p>";
    }
}