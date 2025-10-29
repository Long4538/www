<h2>Danh sách người dùng</h2>
<a href="index.php?controller=admin&action=userForm" class="btn btn-primary">+ Thêm người dùng</a>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên đăng nhập</th>
        <th>Email</th>
        <th>Vai trò</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <a href="index.php?controller=admin&action=userForm&id=<?= $u['id'] ?>">Sửa</a> |
                <a href="index.php?controller=admin&action=deleteUser&id=<?= $u['id'] ?>" onclick="return confirm('Xóa người dùng này?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
