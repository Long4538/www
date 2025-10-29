<h2>Thêm danh mục</h2>
<form action="index.php?act=danhsach_danhmuc&action=add" method="post">
    <input type="text" name="ten_danhmuc" placeholder="Tên danh mục" required>
    <input type="submit" name="add" value="Thêm">
</form>
<?php if (!empty($thongbao)) echo "<p>$thongbao</p>"; ?>
