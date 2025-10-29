<?php
require_once "./model/ProductModel.php";
require_once "./model/CommentModel.php";

class ProductController
{
    public function detail($id)
    {
        // 🔹 Khởi tạo session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productModel = new ProductModel();
        $commentModel = new CommentModel();

        // 🔹 Lấy thông tin sản phẩm
        $sp = $productModel->getProductById($id);
        if (!$sp) {
            die("Sản phẩm không tồn tại!");
        }

        // 🔹 Xử lý gửi bình luận
        $add_result = null;  // Để debug
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            if (isset($_SESSION['user'])) {
                $user_id = $_SESSION['user']['user_id'];
                $content = trim($_POST['content']);
                $rating = $_POST['rating'] ?? 5;

                if ($content !== '') {
                    $add_result = $commentModel->addComment($id, $user_id, $content, $rating);
                    
                    // ✅ Kiểm tra kết quả INSERT
                    if (!$add_result['success']) {
                        echo "<!-- DEBUG: Add comment failed: " . ($add_result['error'] ?? 'Unknown error') . " -->";
                        // Có thể set session error message để hiển thị cho user
                        $_SESSION['error'] = 'Thêm bình luận thất bại: ' . ($add_result['error'] ?? 'Lỗi không xác định');
                    } else {
                        echo "<!-- DEBUG: Add comment success -->";
                        // Set session success nếu cần
                        $_SESSION['success'] = 'Bình luận đã được thêm!';
                    }

                    // 🚫 Loại bỏ usleep và ob_clean (không cần nếu không có output trước)
                    // usleep(200000);  // Remove
                    // if (ob_get_length()) ob_clean();  // Remove nếu không có echo trước

                    header("Location: index.php?act=chitietsanpham&id=$id");
                    exit;
                } else {
                    $_SESSION['error'] = 'Nội dung bình luận không được rỗng!';
                }
            } else {
                $_SESSION['error'] = 'Bạn cần đăng nhập để bình luận!';
            }
        }

        // 🔹 Lấy danh sách bình luận (sẽ fetch mới sau redirect)
        $comments = $commentModel->getCommentsByProduct($id);

        // 🔹 Hiển thị thông báo error/success nếu có (trong view)
        $error_msg = $_SESSION['error'] ?? null;
        $success_msg = $_SESSION['success'] ?? null;
        unset($_SESSION['error'], $_SESSION['success']);  // Clear sau khi dùng

        // 🔹 Hiển thị view (truyền $error_msg, $success_msg nếu cần)
        require "./view/pages/chitietsanpham.php";
    }
}