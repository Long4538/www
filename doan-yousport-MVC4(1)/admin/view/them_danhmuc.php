<div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">➕ Thêm mới danh mục</h1>
    
    <div class="mb-4">
        <a href="index.php?act=danhsach_danhmuc" 
           class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <?php 
    // Hiển thị thông báo lỗi (nếu có từ controller)
    if (isset($thongbao) && $thongbao != "") {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline">' . htmlspecialchars($thongbao) . '</span>
              </div>';
    }
    ?>

    <form action="index.php?act=danhsach_danhmuc&action=add" method="POST">
        <div class="mb-4">
            <label for="ten_danhmuc" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
            <input type="text" id="ten_danhmuc" name="ten_danhmuc" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500"
                   placeholder="Nhập tên danh mục..." required>
        </div>
        
        <div class="mb-6">
            <label for="mota" class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
            <textarea id="mota" name="mota" rows="4" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500"
                      placeholder="Mô tả về danh mục (không bắt buộc)"></textarea>
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" name="them_danhmuc" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                <i class="fas fa-save mr-2"></i> Lưu danh mục
            </button>
            <button type="reset" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                <i class="fas fa-undo mr-2"></i> Nhập lại
            </button>
        </div>
    </form>
</div>