<div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Cập nhật tài khoản</h1>
    
    <div class="mb-4">
        <a href="index.php?act=danhsach_taikhoan" 
           class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <?php 
    // Biến $tk được truyền từ controller (index.php)
    if (isset($thongbao) && $thongbao != "") {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline">' . htmlspecialchars($thongbao) . '</span>
              </div>';
    }
    ?>

    <form action="index.php?act=sua_taikhoan&id=<?= $tk['user_id'] ?>" method="POST">
        <div class="mb-4">
            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập:</label>
            <input type="text" id="full_name" name="full_name" 
                   class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($tk['full_name']) ?>" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" 
                   class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($tk['email']) ?>" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới:</label>
            <input type="password" id="password" name="password" 
                   class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Bỏ trống nếu không muốn đổi">
            <p class="text-xs text-gray-500 mt-1">Để trống ô này nếu bạn không muốn thay đổi mật khẩu.</p>
        </div>

        <div class="mb-6">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Vai trò:</label>
            <select id="role" name="role" required
                    class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                <option value="customer" <?= ($tk['role'] == 'customer') ? 'selected' : '' ?>>Customer (Khách hàng)</option>
                <option value="mod" <?= ($tk['role'] == 'mod') ? 'selected' : '' ?>>Mod (Nhân viên)</option>
                <option value="admin" <?= ($tk['role'] == 'admin') ? 'selected' : '' ?>>Admin (Quản trị)</option>
            </select>
        </div>
        
        <div class="flex items-center justify-start">
            <button type="submit" name="capnhat_taikhoan" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                <i class="fas fa-save mr-2"></i> Cập nhật
            </button>
        </div>
    </form>
</div>