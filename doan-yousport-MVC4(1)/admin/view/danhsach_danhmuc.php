<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Danh sách danh mục</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="index.php?act=danhsach_danhmuc&action=add" 
           class="bg-indigo-600 text-white px-5 py-2 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i> Thêm mới danh mục
        </a>
    </div>

    <?php 
    // Hiển thị thông báo (nếu có từ redirect)
    if (isset($_GET['add_success']) && $_GET['add_success'] == '1') {
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline">Đã thêm danh mục mới.</span>
              </div>';
    }
    if (isset($_GET['update_success']) && $_GET['update_success'] == '1') {
        echo '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline">Đã cập nhật danh mục.</span>
              </div>';
    }
    if (isset($_GET['delete_success']) && $_GET['delete_success'] == '1') {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline">Đã xóa danh mục.</span>
              </div>';
    }
    ?>

    <?php if (!empty($list)) : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="w-full whitespace-nowrap table-auto">
                <thead>
                    <tr class="text-left font-bold bg-gray-50">
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tên danh mục</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Mô tả</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $dm) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b border-gray-200"><?= $dm['id'] ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?= htmlspecialchars($dm['ten_danhmuc']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?= htmlspecialchars($dm['mota']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 text-right">
                                <a href="index.php?act=danhsach_danhmuc&action=edit&id=<?= $dm['id'] ?>" 
                                   class="text-blue-600 hover:text-blue-900 mr-4">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=danhsach_danhmuc&action=delete&id=<?= $dm['id'] ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"
                                   class="text-red-600 hover:text-red-900">
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
            <p class="font-bold">Thông báo</p>
            <p>Chưa có danh mục nào được tạo.</p>
        </div>
    <?php endif; ?>
</div>