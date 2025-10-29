<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🛍️ Danh sách sản phẩm</h1>

    <div class="flex justify-between items-center mb-6">
        <a href="index.php?act=themsanpham" class="bg-indigo-600 text-white px-5 py-2 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i> Thêm mới sản phẩm
        </a>
    </div>

    <?php 
    if (isset($_GET['add_success'])) echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">Đã thêm sản phẩm mới.</div>';
    if (isset($_GET['update_success'])) echo '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">Đã cập nhật sản phẩm.</div>';
    if (isset($_GET['delete_success'])) echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Đã xóa sản phẩm.</div>';
    ?>

    <?php if (!empty($list)) : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="w-full whitespace-nowrap table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-left font-bold">
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Hình ảnh</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tên sản phẩm</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Danh mục</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Giá</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Giảm giá</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $sp) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b border-gray-200"><?= $sp['id'] ?></td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <?php if (!empty($sp['hinh'])): ?>
                                    <img src="view/uploads/<?= htmlspecialchars($sp['hinh']) ?>" alt="Ảnh sản phẩm" class="w-16 h-16 object-cover rounded border border-gray-200">
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Không hình</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800"><?= htmlspecialchars($sp['ten_sanpham']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?= htmlspecialchars($sp['ten_danhmuc']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 font-semibold text-green-600"><?= number_format($sp['gia'], 0, ',', '.') ?>₫</td>
                            <td class="px-6 py-4 border-b border-gray-200 font-semibold text-red-500"><?= number_format($sp['giam_gia'], 0, ',', '.') ?>₫</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-right">
                                <a href="index.php?act=suasanpham&id=<?= $sp['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-4 font-medium">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=danhsach_sanpham&action=delete&id=<?= $sp['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?');" class="text-red-600 hover:text-red-900 font-medium">
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
            <p>Chưa có sản phẩm nào.</p>
        </div>
    <?php endif; ?>
</div>