<?php
    require_once '../../classes/User.class.php';
    session_start();

    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        exit;
    }

    $db = new Db();
    $user = new User($db);
    $username = $_SESSION['username'];
    $userInfo = $user->getUserByUsername($username);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email']);
        $user->updateUserInfo($username,$email);
        $_SESSION['success'] = "Cập nhật thông tin";
        header('Location: profile.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
</head>
<body>
    <h1>Thông tin cá nhân</h1>
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Tài khoản đăng nhập:</label>
        <input type="text" id="username" value="<?php echo htmlspecialchars($userInfo[0]['username']); ?>" disabled>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userInfo[0]['email']); ?>" required>
        <br>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>