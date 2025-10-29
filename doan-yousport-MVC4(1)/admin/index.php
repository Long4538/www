<?php
session_start();

// ✅ Logic kiểm tra đăng nhập
if (!isset($_SESSION['admin']) && (!isset($_GET['act']) || $_GET['act'] !== 'admin_login' && $_GET['act'] !== 'handle_login')) {
    header("Location: index.php?act=admin_login");
    exit;
}

// ✅ Nạp các file model
require_once __DIR__ . "/model/database.php";
require_once __DIR__ . "/controller/OrderController.php";
require_once "model/pdo.php";
require_once "model/danhmuc.php";
require_once "model/sanpham.php";
require_once "model/taikhoan.php";
require_once "model/binhluan.php";
require_once "model/thongke.php";

// ✅ 1. Đặt một biến "cờ"
$show_admin_layout = true;

if (isset($_GET['act'])) {
    switch ($_GET['act']) {

        /* ------------------ CÁC TRANG KHÔNG CẦN LAYOUT ------------------ */
        case 'admin_login':
            $show_admin_layout = false; // ⛔ Tắt layout
            include "admin_login.php";
            break;

        case 'handle_login':
            $show_admin_layout = false; // ⛔ Tắt layout
            if (isset($_POST['login_admin'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $tk = check_admin_login($email, $password);
                if ($tk) {
                    $_SESSION['admin'] = $tk;
                    // Dùng header() thay vì echo script
                    header("Location: index.php?act=dashboard");
                    exit;
                } else {
                    $error = "Sai email hoặc mật khẩu!";
                    include "admin_login.php"; // Hiển thị lại form login với lỗi
                }
            }
            break;

        case 'logout':
            $show_admin_layout = false; // ⛔ Tắt layout
            session_destroy();
            header("Location: index.php?act=admin_login");
            exit;

        /* ------------------ DANH MỤC (ĐÃ SỬA) ------------------ */
        case 'danhsach_danhmuc':
            if (isset($_GET['action']) && $_GET['action'] == 'add') {
                if (isset($_POST['them_danhmuc'])) {
                    $ten_danhmuc = $_POST['ten_danhmuc'];
                    $mota = $_POST['mota'] ?? '';

                    if (!empty($ten_danhmuc)) {
                        insert_danhmuc($ten_danhmuc, $mota);
                        header("Location: index.php?act=danhsach_danhmuc&add_success=1"); // Chuyển trang
                        exit;
                    } else {
                        $thongbao = "⚠️ Vui lòng nhập tên danh mục!";
                    }
                }
                $view_name = "view/them_danhmuc.php"; // Gán view
            } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
                $id = $_GET['id'];
                $danhmuc = get_danhmuc_by_id($id);
                if (!$danhmuc) {
                    header("Location: index.php?act=danhsach_danhmuc"); exit;
                }
                if (isset($_POST['capnhat_danhmuc'])) {
                    $ten_danhmuc = $_POST['ten_danhmuc'];
                    $mota = $_POST['mota'] ?? '';
                    update_danhmuc($id, $ten_danhmuc, $mota);
                    header("Location: index.php?act=danhsach_danhmuc&update_success=1"); // Chuyển trang
                    exit;
                }
                $view_name = "view/sua_danhmuc.php"; // Gán view
            } elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
                $id = $_GET['id'];
                delete_danhmuc($id);
                header("Location: index.php?act=danhsach_danhmuc&delete_success=1"); // Chuyển trang
                exit;
            } else {
                // ✅ ĐÂY LÀ DÒNG BỊ THIẾU GÂY LỖI CHO BẠN
                $list = get_all_danhmuc();
                $view_name = "view/danhsach_danhmuc.php"; // Gán view
            }
            break;

        /* ------------------ SẢN PHẨM (ĐÃ SỬA) ------------------ */
        case 'danhsach_sanpham':
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                $id = $_GET['id'];
                delete_sanpham($id);
                header("Location: index.php?act=danhsach_sanpham&delete_success=1");
                exit;
            } else {
                $list = get_all_sanpham();
                $view_name = "view/danhsach_sanpham.php";
            }
            break;

        case 'themsanpham':
            $list_danhmuc = get_all_danhmuc();
            if (isset($_POST['them_sanpham'])) {
                $ten = $_POST['ten_sanpham'];
                $gia = $_POST['gia'];
                $giamgia = $_POST['giamgia'];
                $mota = $_POST['mota'];
                $catalog_id = $_POST['catalog_id'];
                $hinh = "";
                if (isset($_FILES['hinh']) && $_FILES['hinh']['name'] != "") {
                    $target_dir = "view/uploads/";
                    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                    $hinh = basename($_FILES["hinh"]["name"]);
                    $target_file = $target_dir . $hinh;
                    move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file);
                }

                if (!empty($ten) && !empty($gia)) {
                    insert_sanpham($ten, $gia, $giamgia, $hinh, $mota, $catalog_id);
                    header("Location: index.php?act=danhsach_sanpham&add_success=1");
                    exit;
                } else {
                    $thongbao = "⚠️ Vui lòng nhập đầy đủ thông tin sản phẩm!";
                }
            }
            $view_name = "view/them_sanpham.php";
            break;

            /* ------------------ SỬA SẢN PHẨM (BỔ SUNG) ------------------ */
        case 'suasanpham': // <-- THÊM CASE NÀY
            if (!isset($_GET['id'])) { // Kiểm tra xem có ID không
                header("Location: index.php?act=danhsach_sanpham"); 
                exit;
            }
            $id = $_GET['id'];
            
            // Lấy thông tin sản phẩm cần sửa
            $sp = get_sanpham_by_id($id); // <-- Đảm bảo bạn có hàm này trong model/sanpham.php
            if (!$sp) { // Nếu không tìm thấy sản phẩm
                header("Location: index.php?act=danhsach_sanpham"); 
                exit;
            }

            // Lấy danh sách danh mục cho dropdown
            $list_danhmuc = get_all_danhmuc();

            // Xử lý khi người dùng nhấn nút "Cập nhật"
            if (isset($_POST['capnhat_sanpham'])) {
                $ten = $_POST['ten_sanpham'];
                $gia = $_POST['gia'];
                $giamgia = $_POST['giamgia'];
                $mota = $_POST['mota'];
                $catalog_id = $_POST['catalog_id'];
                $hinh = $sp['image_main']; // Giữ lại ảnh cũ mặc định

                // Xử lý upload ảnh mới (nếu có)
                if (isset($_FILES['hinh']) && $_FILES['hinh']['name'] != "") {
                    $target_dir = "view/uploads/"; // <-- Đảm bảo đường dẫn này đúng
                    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                    $hinh_moi = basename($_FILES["hinh"]["name"]);
                    $target_file = $target_dir . $hinh_moi;
                    if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
                        $hinh = $hinh_moi; // Chỉ cập nhật tên ảnh mới nếu upload thành công
                    } else {
                        // Có thể thêm thông báo lỗi upload ở đây
                    }
                }

                if (!empty($ten) && !empty($gia)) {
                    // Gọi hàm cập nhật sản phẩm trong model
                    update_sanpham($id, $ten, $gia, $giamgia, $hinh, $mota, $catalog_id); // <-- Đảm bảo bạn có hàm này
                    header("Location: index.php?act=danhsach_sanpham&update_success=1");
                    exit;
                } else {
                    $thongbao = "⚠️ Vui lòng nhập đầy đủ Tên và Giá sản phẩm!";
                }
            }

            // Chỉ định view sửa sản phẩm
            $view_name = "view/sua_sanpham.php"; 
            break; 
            
        // ... các case khác của bạn ...

        /* ------------------ TÀI KHOẢN (ĐÃ SỬA) ------------------ */
        case 'danhsach_taikhoan':
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                $id = $_GET['id'];
                delete_taikhoan($id);
                header("Location: index.php?act=danhsach_taikhoan&delete_success=1");
                exit;
            } else {
                $list = get_all_taikhoan();
                $view_name = "view/danhsach_taikhoan.php";
            }
            break;

        case 'them_taikhoan':
            if (isset($_POST['them_taikhoan'])) {
                $full_name = $_POST['full_name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $role = $_POST['role'] ?? 0;

                if (!empty($full_name) && !empty($email) && !empty($password)) {
                    insert_taikhoan($full_name, $password, $email, $role);
                    header("Location: index.php?act=danhsach_taikhoan&add_success=1");
                    exit;
                } else {
                    $thongbao = "⚠️ Vui lòng điền đầy đủ thông tin!";
                }
            }
            $view_name = "view/them_taikhoan.php";
            break;

        case 'sua_taikhoan':
            $id = $_GET['id'];
            $user = get_taikhoan_by_id($id);
            $tk = $user;
            if (!$user) {
                header("Location: index.php?act=danhsach_taikhoan"); exit;
            }
            if (isset($_POST['capnhat_taikhoan'])) {
                $full_name = $_POST['full_name'];
                $email = $_POST['email'];
                $password = !empty($_POST['password']) ? $_POST['password'] : null;
                $role = $_POST['role'] ?? 0;
                update_taikhoan($id, $full_name, $email, $password, $role);
                header("Location: index.php?act=danhsach_taikhoan&update_success=1");
                exit;
            }
            $view_name = "view/sua_taikhoan.php";
            break;

        /* ------------------ BÌNH LUẬN (ĐÃ SỬA) ------------------ */
        case 'danhsach_binhluan':
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                $id = $_GET['id'];
                delete_binhluan($id);
                header("Location: index.php?act=danhsach_binhluan&delete_success=1");
                exit;
            } else {
                $list = get_all_binhluan();
                $view_name = "view/danhsach_binhluan.php";
            }
            break;

        /* ------------------ THỐNG KÊ ------------------ */
        case 'thongke':
            $tong = get_thongke_tong();
            $tk_danhmuc = get_thongke_theodanhmuc();
            $view_name = "view/thongke.php";
            break;

        /* ------------------ DASHBOARD ------------------ */
        case 'dashboard':
            $tongquan = get_tongquan();
            $tyle_donhang = get_tyle_donhang();
            $donmoi = get_5_donhang_moinhat();
            $view_name = "view/dashboard.php";
            break;

        /* ------------------ ĐƠN HÀNG (ĐÃ SỬA) ------------------ */
        /* ------------------ ĐƠN HÀNG (ĐÃ SỬA LẠI HÀM MODEL) ------------------ */
        case 'danhsach_donhang':
            require_once "model/OrderModel.php"; // Đảm bảo model được nạp
            $conn = pdo_get_connection(); // Lấy kết nối PDO
            $orderModel = new OrderModel($conn); // Tạo instance của OrderModel
            
            // Lấy trạng thái lọc từ URL (nếu có)
            $status_filter = $_GET['status'] ?? ''; // Dùng '' thay vì null để khớp với logic Model
            
            // ✅ SỬA Ở ĐÂY: Gọi đúng hàm getAllOrders() từ Model
            $orders = $orderModel->getAllOrders($status_filter); 

            // Xử lý action (Update/Delete)
            if (isset($_GET['action'])) {
                $id = $_GET['id'] ?? null;
                $current_status_filter = $_GET['current_status'] ?? ''; // Lấy lại bộ lọc hiện tại để giữ sau khi redirect

                if ($id) { // Chỉ thực hiện nếu có ID
                    switch ($_GET['action']) {
                        case 'update':
                            $new_status = $_GET['status'] ?? '';
                            // Thêm các trạng thái hợp lệ của bạn vào đây
                            if (in_array($new_status, ['pending', 'paid', 'delivered', 'cancelled'])) { 
                                $orderModel->updateStatus($id, $new_status); // Gọi hàm update từ Model
                                header("Location: index.php?act=danhsach_donhang&update_success=1&status=" . $current_status_filter); 
                                exit;
                            }
                            break;
                        case 'delete':
                            $orderModel->deleteOrder($id); // Gọi hàm delete từ Model
                            header("Location: index.php?act=danhsach_donhang&delete_success=1&status=" . $current_status_filter); 
                            exit;
                    }
                }
            }
            
            // Chỉ định View để hiển thị
            $view_name = "view/danhsach_donhang.php"; 
            break;
        default:
            $tongquan = get_tongquan();
            $tyle_donhang = get_tyle_donhang();
            $donmoi = get_5_donhang_moinhat();
            $view_name = "view/dashboard.php";
            break;
    }
} else {
    // Trang mặc định khi không có 'act'
    $tongquan = get_tongquan();
    $tyle_donhang = get_tyle_donhang();
    $donmoi = get_5_donhang_moinhat();
    $view_name = "view/dashboard.php";
}

// ✅ 2. Logic Hiển thị Layout
// Khối này sẽ chạy sau khi switch-case xác định xong $view_name
if ($show_admin_layout) {
    // 1. Tải Header
    include "view/header.php";

    // 2. Tải View
    if (isset($view_name) && file_exists($view_name)) {
        include $view_name;
    } else {
        echo "<h3 class='text-red-500 p-6'>Lỗi: Không tìm thấy file view '$view_name'</h3>";
    }

    // 3. Tải Footer
    include "view/footer.php";
}
?>