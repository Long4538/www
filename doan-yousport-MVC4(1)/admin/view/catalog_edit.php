<h2>Cập nhật danh mục</h2>
<form action="index.php?act=danhsach_danhmuc&action=update" method="post">
    <input type="hidden" name="id" value="<?= $dm['id'] ?>">
    <input type="text" name="ten_danhmuc" value="<?= $dm['ten_danhmuc'] ?>" required>
    <input type="submit" name="update" value="Cập nhật">
</form>
