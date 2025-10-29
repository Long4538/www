<h2><?= isset($user) ? "Cập nhật người dùng" : "Thêm người dùng mới" ?></h2>

<form method="post" action="index.php?controller=admin&action=<?= isset($user) ? 'updateUser' : 'storeUser' ?>">
    <?php if (isset($user)): ?>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <?php endif; ?>

    <label>Tên đăng nhập:</label>
    <input type="text" name="username" value="<?= $user['username'] ?? '' ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $user['email'] ?? '' ?>" required><br>

    <?php if (!isset($user)): ?>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br>
    <?php endif; ?>

    <label>Vai trò:</label>
    <select name="role">
        <option value="user" <?= isset($user) && $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= isset($user) && $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select><br>

    <button type="submit">Lưu</button>
    <a href="index.php?controller=admin&action=userList">Hủy</a>
</form>
