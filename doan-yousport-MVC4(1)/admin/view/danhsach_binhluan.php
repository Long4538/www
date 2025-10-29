<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">💬 Danh sách bình luận</h1>

    <?php 
    if (isset($_GET['delete_success'])) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                Đã xóa bình luận.
              </div>';
    }
    ?>

    <?php if (!empty($list)) : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="w-full whitespace-nowrap table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-left font-bold">
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Sản phẩm</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Người bình luận</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Nội dung</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Đánh giá</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Ngày</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $bl) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b border-gray-200"><?= $bl['review_id'] ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800">
                                <?= htmlspecialchars($bl['ten_sanpham'] ?? 'Không xác định') ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <?= htmlspecialchars($bl['ten_nguoidung'] ?? 'Ẩn danh') ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-700" style="min-width: 200px; white-space: normal;">
                                <?= htmlspecialchars($bl['comment']) ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-yellow-500 font-semibold">
                                <?= $bl['rating'] ?> ⭐
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                <?= date('d/m/Y H:i', strtotime($bl['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-right">
                                <a href="index.php?act=danhsach_binhluan&action=delete&id=<?= $bl['review_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?');" class="text-red-600 hover:text-red-900 font-medium">
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
            <p>Chưa có bình luận nào.</p>
        </div>
    <?php endif; ?>
</div>