<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">👥 Danh sách tài khoản</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="index.php?act=them_taikhoan" 
           class="bg-indigo-600 text-white px-5 py-2 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i> Thêm mới tài khoản
        </a>
    </div>

    <?php 
    // Hiển thị thông báo (nếu có từ redirect)
    if (isset($_GET['add_success'])) echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">Đã thêm tài khoản mới.</div>';
    if (isset($_GET['update_success'])) echo '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">Đã cập nhật tài khoản.</div>';
    if (isset($_GET['delete_success'])) echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Đã xóa tài khoản.</div>';
    ?>

    <?php if (!empty($list)) : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="w-full whitespace-nowrap table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-left font-bold">
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tên đăng nhập</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Vai trò</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $tk) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b border-gray-200"><?= $tk['user_id'] ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800"><?= htmlspecialchars($tk['full_name']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?= htmlspecialchars($tk['email']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <?php 
                                $role = strtolower($tk['role']);
                                $role_class = 'bg-gray-100 text-gray-600'; // Mặc định
                                if ($role == 'admin') {
                                    $role_class = 'bg-red-100 text-red-700';
                                } elseif ($role == 'mod') {
                                    $role_class = 'bg-yellow-100 text-yellow-700';
                                } elseif ($role == 'customer') {
                                    $role_class = 'bg-blue-100 text-blue-700';
                                }
                                ?>
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full <?= $role_class ?>">
                                    <?= htmlspecialchars($tk['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-right">
                                <a href="index.php?act=sua_taikhoan&id=<?= $tk['user_id'] ?>" 
                                   class="text-blue-600 hover:text-blue-900 mr-4 font-medium">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=danhsach_taikhoan&action=delete&id=<?= $tk['user_id'] ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');"
                                   class="text-red-600 hover:text-red-900 font-medium">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p>Chưa có tài khoản nào.</p>
        </div>
    <?php endif; ?>
</div>