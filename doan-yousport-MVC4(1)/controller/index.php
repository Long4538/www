<?php
session_start(); 
include "../view/pages/header.php"; 
require_once "UserController.php";
require_once "../model/UserModel.php";
$userController = new UserController(); // ✅ tạo đối tượng controller
?>
  

<?php
require_once "../model/ProductModel.php";

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'gioithieu':
            include "../view/pages/gioithieu.php";
            break;
        case 'lienhe':
            include "../view/pages/lienhe.php";
            break;
        case 'giohang':
            include "../view/pages/giohang.php";
            break;
        case 'checkout':
            include "../view/pages/checkout.php";
            break;
        case 'success':
            include "../view/pages/success.php";
            break;  
        case 'donhang':
            include "../view/pages/donhang.php";
            break;
        case 'chitiet_donhang':
            include "../view/pages/chitiet_donhang.php";
            break;     
        case 'qa':
            include "../view/pages/qa.php";
            break;
        case 'login':
            include "../view/pages/login.php";
            break;
        case 'register':
            include "../view/pages/register.php";
            break;
        case 'profile':
            $userController->showProfile();
            break;
        // case 'profile':
        //       // Kiểm tra đăng nhập trước khi load profile
        //       if (!isset($_SESSION['users'])) {
        //           header("Location: index.php?act=login");  // Redirect về root (sẽ qua controller)
        //           exit;
        //       }
        //       // Load view profile (sẽ tự có header/footer)
        //       include "../view/profile.php";
        //       break;
            // Giả sử bạn có switch($act) để route
        case 'logout':
            $userController = new UserController();
            $userController->handleLogout();
            break;
        // Đồ Đá Banh
        case 'dtt_dabong':
            include "../view/pages/dtt_dabong.php";
            break;
        case 'chitietsanpham':
            if (isset($_GET['id'])) {
                $productModel = new ProductModel();
                require_once "../model/CommentModel.php";  // ✅ thêm dòng này
                $commentModel = new CommentModel();        // ✅ khởi tạo model bình luận
                $id = $_GET['id'];                         // ✅ lấy id sản phẩm
                // Lấy chi tiết sản phẩm
                $sp = $productModel->getProductById($id);
                // Lấy danh sách bình luận
                $comments = $commentModel->getCommentsByProduct($id); // ✅ thêm dòng này
                include "../view/pages/chitietsanpham.php"; // ✅ view cần dùng biến $comments
            } else {
                echo "<p>Không tìm thấy sản phẩm!</p>";
            }
            break;

        // Đồ cầu lông
        case 'dtt_caulong':
            include "../view/pages/dtt_caulong.php";
            break;
        case 'chitietsanpham_caulong':
            if (isset($_GET['id'])) {
                $productModel = new ProductModel();
                require_once "../model/CommentModel.php";  // ✅ thêm dòng này
                $commentModel = new CommentModel();        // ✅ khởi tạo model bình luận
                $id = $_GET['id'];                         // ✅ lấy id sản phẩm
                // Lấy chi tiết sản phẩm
                $sp = $productModel->getProductById($id);
                // Lấy danh sách bình luận
                $comments = $commentModel->getCommentsByProduct($id); // ✅ thêm dòng này
                include "../view/pages/chitietsanpham_caulong.php.php"; // ✅ view cần dùng biến $comments
            } else {
                echo "<p>Không tìm thấy sản phẩm!</p>";
            }
            break;
        // Đồ bóng rổ 
        case 'dtt_bongro':
            include "../view/pages/dtt_bongro.php";
            break;
        case 'chitietsanpham_bongro':
            if (isset($_GET['id'])) {
                $productModel = new ProductModel();
                require_once "../model/CommentModel.php";  // ✅ thêm dòng này
                $commentModel = new CommentModel();        // ✅ khởi tạo model bình luận
                $id = $_GET['id'];                         // ✅ lấy id sản phẩm
                // Lấy chi tiết sản phẩm
                $sp = $productModel->getProductById($id);
                // Lấy danh sách bình luận
                $comments = $commentModel->getCommentsByProduct($id); // ✅ thêm dòng này
                include "../view/pages/chitietsanpham_bongro.php"; // ✅ view cần dùng biến $comments
            } else {
                echo "<p>Không tìm thấy sản phẩm!</p>";
            }
            break;
        // Đồ bóng chuyền
        case 'dtt_bongchuyen':
            include "../view/pages/dtt_bongchuyen.php";
            break;
        case 'chitietsanpham_bongchuyen':
            if (isset($_GET['id'])) {
                $productModel = new ProductModel();
                require_once "../model/CommentModel.php";  // ✅ thêm dòng này
                $commentModel = new CommentModel();        // ✅ khởi tạo model bình luận
                $id = $_GET['id'];                         // ✅ lấy id sản phẩm
                // Lấy chi tiết sản phẩm
                $sp = $productModel->getProductById($id);
                // Lấy danh sách bình luận
                $comments = $commentModel->getCommentsByProduct($id); // ✅ thêm dòng này
                include "../view/pages/chitietsanpham_bongchuyen.php"; // ✅ view cần dùng biến $comments
            } else {
                echo "<p>Không tìm thấy sản phẩm!</p>";
            }
            break;
        // Phụ kiện
        case 'phukien':
            include "../view/pages/phukien.php";
            break;
        case 'chitietsanpham_phukien':
            if (isset($_GET['id'])) {
                $productModel = new ProductModel();
                require_once "../model/CommentModel.php";  // ✅ thêm dòng này
                $commentModel = new CommentModel();        // ✅ khởi tạo model bình luận
                $id = $_GET['id'];                         // ✅ lấy id sản phẩm
                // Lấy chi tiết sản phẩm
                $sp = $productModel->getProductById($id);
                // Lấy danh sách bình luận
                $comments = $commentModel->getCommentsByProduct($id); // ✅ thêm dòng này
                include "../view/pages/chitietsanpham_phukien.php"; // ✅ view cần dùng biến $comments
            } else {
                echo "<p>Không tìm thấy sản phẩm!</p>";
            }
            break;
        default:
            include "../view/pages/home.php";
            break;
    }
} else {
    include "../view/pages/home.php";
}


?>


<?php include "../view/pages/footer.php"; ?>