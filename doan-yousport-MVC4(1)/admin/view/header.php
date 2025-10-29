<?php
// Lấy thông tin admin
$admin_name = $_SESSION['admin']['full_name'] ?? 'Admin';

// Lấy 'act' và 'action' hiện tại để xác định link nào đang 'active'
// Đây là logic DUY NHẤT tôi thêm vào, nó không làm thay đổi link, chỉ để tô màu
$current_act = $_GET['act'] ?? 'dashboard';
$current_action = $_GET['action'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị YouSport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS tùy chỉnh cho thanh cuộn và link active */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        
        /* Class cho link sidebar đang active */
        .sidebar-link.active {
            background-color: #eef2ff; /* Màu nền indigo-50 */
            color: #4f46e5; /* Màu chữ indigo-600 */
            font-weight: 600;
        }
        .sidebar-link.active i {
            color: #4f46e5; /* Màu icon */
        }
    </style>
</head>

<body class="h-full">
    <div class="flex h-screen">
        
        <aside class="w-64 flex-shrink-0 bg-white text-gray-700 flex flex-col border-r border-gray-200">
            <div class="h-16 flex items-center justify-center text-2xl font-bold text-indigo-600 shadow-sm">
                YouSport Admin
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                
                <a href="index.php?act=dashboard" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt w-6 text-gray-400"></i>
                    <span class="ml-3">Trang chủ</span>
                </a>
                
                <a href="index.php?act=danhsach_danhmuc" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_danhmuc' && $current_action == '') ? 'active' : '' ?>">
                    <i class="fas fa-list-alt w-6 text-gray-400"></i>
                    <span class="ml-3">Danh sách danh mục</span>
                </a>
                
                <a href="index.php?act=danhsach_danhmuc&action=add" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_danhmuc' && $current_action == 'add') ? 'active' : '' ?>">
                    <i class="fas fa-plus-circle w-6 text-gray-400"></i>
                    <span class="ml-3">Thêm danh mục</span>
                </a>
                
                <a href="index.php?act=danhsach_sanpham" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_sanpham') ? 'active' : '' ?>">
                    <i class="fas fa-box-open w-6 text-gray-400"></i>
                    <span class="ml-3">Danh sách sản phẩm</span>
                </a>
                
                <a href="index.php?act=themsanpham" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'themsanpham') ? 'active' : '' ?>">
                    <i class="fas fa-plus-square w-6 text-gray-400"></i>
                    <span class="ml-3">Thêm sản phẩm</span>
                </a>
                
                <a href="index.php?act=danhsach_taikhoan" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_taikhoan') ? 'active' : '' ?>">
                    <i class="fas fa-users w-6 text-gray-400"></i>
                    <span class="ml-3">Tài khoản</span>
                </a>
                
                <a href="index.php?act=danhsach_binhluan" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_binhluan') ? 'active' : '' ?>">
                    <i class="fas fa-comments w-6 text-gray-400"></i>
                    <span class="ml-3">Bình luận</span>
                </a>
                
                <a href="index.php?act=thongke" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'thongke') ? 'active' : '' ?>">
                    <i class="fas fa-chart-pie w-6 text-gray-400"></i>
                    <span class="ml-3">Thống kê</span>
                </a>
                
                <a href="index.php?act=danhsach_donhang" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 sidebar-link <?= ($current_act == 'danhsach_donhang') ? 'active' : '' ?>">
                    <i class="fas fa-receipt w-6 text-gray-400"></i>
                    <span class="ml-3">Đơn hàng</span>
                </a>
                
                <a href="../index.php" target="_blank" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 mt-4 border-t pt-4">
                    <i class="fas fa-arrow-alt-circle-left w-6 text-gray-400"></i>
                    <span class="ml-3">Trở về trang chính</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            
            <header class="h-16 bg-indigo-600 shadow-md flex items-center justify-end px-6 flex-shrink-0">
                
                <div class="admin-info flex items-center space-x-4">
                    <span class="text-white">Xin chào, <strong><?= htmlspecialchars($admin_name) ?></strong></span>
                    <a href="index.php?act=logout" class="px-3 py-1 bg-red-500 text-white rounded text-sm font-medium hover:bg-red-600">
                        Đăng xuất
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
            