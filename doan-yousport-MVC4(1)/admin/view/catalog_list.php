<div class="content">
    <h2 class="text-center text-danger mb-4">Danh sách danh mục sản phẩm</h2>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID danh mục</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($catalogs as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <a href="index.php?act=edit_catalog&id=<?= $row['id'] ?>" class="btn btn-primary">Sửa</a>
                        <a href="index.php?act=delete_catalog&id=<?= $row['id'] ?>" class="btn btn-danger"
                           onclick="return confirm('Xóa danh mục này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

