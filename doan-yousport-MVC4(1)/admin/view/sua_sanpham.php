<?php
// Controller (index.php) phải truyền $sp (sản phẩm) và $list_danhmuc
if (!isset($sp)) {
    echo "<p class='text-red-500 p-6'>Lỗi: Không tìm thấy dữ liệu sản phẩm.</p>";
    return;
}
if (!isset($list_danhmuc)) {
     echo "<p class='text-red-500 p-6'>Lỗi: Không tìm thấy danh sách danh mục.</p>";
    return; // Cần $list_danhmuc để hiển thị dropdown
}
?>
<div class="bg-white shadow rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Cập nhật sản phẩm</h1>
    
    <div class="mb-4">
        <a href="index.php?act=danhsach_sanpham" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <?php 
    // Hiển thị thông báo lỗi (nếu có)
    if (isset($thongbao) && $thongbao != "") {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline">' . htmlspecialchars($thongbao) . '</span>
              </div>';
    }
    ?>

    <form action="index.php?act=suasanpham&id=<?= $sp['product_id'] // ✅ Sửa thành 'product_id' ?>" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="ten_sanpham" class="block text-gray-700 text-sm font-bold mb-2">Tên sản phẩm:</label>
                    <input type="text" id="ten_sanpham" name="ten_sanpham" value="<?= htmlspecialchars($sp['name'] ?? '') // ✅ Sửa thành 'name' ?>" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="gia" class="block text-gray-700 text-sm font-bold mb-2">Giá (VNĐ):</label>
                    <input type="number" id="gia" name="gia" min="0" value="<?= $sp['price'] ?? 0 // ✅ Sửa thành 'price' ?>" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="giamgia" class="block text-gray-700 text-sm font-bold mb-2">Giảm giá (VNĐ):</label>
                    <input type="number" id="giamgia" name="giamgia" min="0" value="<?= $sp['discount'] ?? 0 // ✅ Sửa thành 'discount' ?>" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <div class="mb-4">
                    <label for="catalog_id" class="block text-gray-700 text-sm font-bold mb-2">Danh mục:</label>
                    <select id="catalog_id" name="catalog_id" required class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($list_danhmuc as $dm): ?>
                            <option value="<?= $dm['id'] // Giả định danh mục dùng 'id' và 'ten_danhmuc' ?>" <?= ($dm['id'] == $sp['catalog_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dm['ten_danhmuc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="hinh" class="block text-gray-700 text-sm font-bold mb-2">Hình ảnh (Để trống nếu không đổi):</label>
                    <input type="file" id="hinh" name="hinh" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <?php if (!empty($sp['image_main'])): // ✅ Sửa thành 'image_main' ?>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ảnh hiện tại:</label>
                    <img src="view/uploads/<?= htmlspecialchars($sp['image_main']) // ✅ Sửa thành 'image_main' ?>" alt="Ảnh sản phẩm" class="w-24 h-24 object-cover rounded border border-gray-200">
                <?php endif; ?>
            </div>
            <div class="md:col-span-2 mb-4">
                <label for="mota" class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
                <textarea id="mota" name="mota" rows="4" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= htmlspecialchars($sp['description'] ?? '') // ✅ Sửa thành 'description' ?></textarea>
            </div>
        </div>
        
        <div class="flex items-center justify-start mt-6">
            <button type="submit" name="capnhat_sanpham" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline transition duration-200">
                <i class="fas fa-save mr-2"></i> Cập nhật sản phẩm
            </button>
        </div>
    </form>
</div>