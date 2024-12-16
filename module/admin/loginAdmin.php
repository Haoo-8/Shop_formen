<?php
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';
session_start();
$db = new Db();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra dữ liệu đầu vào 
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
    } else {
        $userData = $user->checkLogin($username, $password);
        if ($userData) {
            $_SESSION['user'] = $userData['username']; // Đảm bảo key đúng 'username'
            $_SESSION['role'] = $userData['role'];
            header('Location: ./index.php');
            exit;
        } else {
            $_SESSION['error'] = "Sai tài khoản hoặc mật khẩu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Đăng nhập</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body>
    <div class="login-container">
        <form class="login-form" action="./loginAdmin.php" method="POST">
            <h2>Đăng nhập Admin</h2> <?php if (isset($error)): ?> <p class="error"><?php echo htmlspecialchars($error); ?></p> <?php endif; ?> <label for="username">Tên đăng nhập:</label> <input type="text" id="username" name="username" required> <label for="password">Mật khẩu:</label> <input type="password" id="password" name="password" required> <button type="submit">Đăng nhập</button>
        </form>
    </div>
</body>

</html>