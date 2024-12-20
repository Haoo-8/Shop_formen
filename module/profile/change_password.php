<?php
session_start();
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$db = new Db();
$user = new User($db);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Kiểm tra mật khẩu cũ
    $sql = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($current_password, $user['password'])) {
        // Cập nhật mật khẩu mới
        $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $update_stmt = $db->prepare($update_sql);
        $update_stmt->execute([$new_password, $user_id]);

        echo "Mật khẩu đã được thay đổi.";
    } else {
        echo "Mật khẩu hiện tại không chính xác.";
    }
}
?>

<form method="POST" action="">
    <label>Mật khẩu hiện tại:</label>
    <input type="password" name="current_password" required>

    <label>Mật khẩu mới:</label>
    <input type="password" name="new_password" required>

    <button type="submit">Đổi mật khẩu</button>
</form>
<a href="profile.php">Quay lại hồ sơ</a>
