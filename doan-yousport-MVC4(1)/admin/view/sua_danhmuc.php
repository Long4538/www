<?php
// Controller (index.php) phải truyền biến $danhmuc vào
if (!isset($danhmuc)) {
    echo "<p class='text-red-500 p-6'>Lỗi: Không tìm thấy dữ liệu danh mục.</p>";
    return; // Dừng lại nếu không có dữ liệu
}
?>
<div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Cập nhật danh mục</h1>
    
    <div class="mb-4">
        <a href="index.php?act=danhsach_danhmuc" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <form action="index.php?act=danhsach_danhmuc&action=edit&id=<?= $danhmuc['catalog_id'] ?>" method="POST">
        <div class="mb-4">
            <label for="ten_danhmuc" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
            <input type="text" id="ten_danhmuc" name="ten_danhmuc" 
                   class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($danhmuc['name']) ?>" required>
        </div>
        
        <div class="mb-6">
            <label for="mota" class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
            <textarea id="mota" name="mota" rows="4" 
                      class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500"
                      placeholder="Mô tả về danh mục (không bắt buộc)"><?= htmlspecialchars($danhmuc['description'] ?? '') ?></textarea>
        </div>
        
        <div class="flex items-center justify-start">
            <button type="submit" name="capnhat_danhmuc" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                <i class="fas fa-save mr-2"></i> Cập nhật
            </button>
        </div>
    </form>
</div>