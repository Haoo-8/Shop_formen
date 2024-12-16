
<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$db = new Db();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

    if ($action === 'add') {
        $fullName = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role = $_POST['role'];
        $user->addUser($fullName,$password, $email,  $role);
    } elseif ($action === 'edit') {
        $fullName = trim($_POST['username']);
        $email = trim($_POST['email']);
        $role = $_POST['role'];
        $user->updateUser($userId, $fullName, $email, $role);
    } elseif ($action === 'delete' && $userId > 0) {
        $user->deleteUser($userId);
    } elseif ($action === 'update_status') {
        $status = $_POST['status'];
        $user->updateUserStatus($userId, $status);
    }

    header("Location: manage_users.php");
    exit;
}

$users = $user->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
</head>
<body>
    <h1>Quản lý người dùng</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['status']; ?></td>
                    <td>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <select name="status">
                                <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="blocked" <?php echo $user['status'] === 'blocked' ? 'selected' : ''; ?>>Blocked</option>
                            </select>
                            <button type="submit" name="action" value="update_status">Cập nhật</button>
                        </form>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit" name="action" value="delete">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Thêm người dùng mới</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Họ tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="action" value="add">Thêm</button>
    </form>
</body>
</html>
