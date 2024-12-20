<?php
session_start();
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
print_r($_SESSION);
$db = new Db();
$user = new User($db);
$user_id = $_SESSION['user_id'];
$userInfo = $user->getUserById($user_id);


if (!$userInfo) {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ tài khoản</title>
</head>
<body>
    <h1>Hồ sơ cá nhân</h1>
    <p><strong>Tên đăng nhập:</strong> <?php echo htmlspecialchars($userInfo['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></p>
    <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($userInfo['fullname'] ?? 'Chưa cập nhật'); ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($userInfo['phone'] ?? 'Chưa cập nhật'); ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($userInfo['address'] ?? 'Chưa cập nhật'); ?></p>
    <p><strong>Ngày tạo tài khoản:</strong> <?php echo htmlspecialchars($userInfo['created_at']); ?></p>

    <h2>Chức năng</h2>
    <ul>
        <li><a href="edit_profile.php">Chỉnh sửa thông tin</a></li>
        <li><a href="change_password.php">Đổi mật khẩu</a></li>
        <li><a href="order_history.php">Xem lịch sử đơn hàng</a></li>
        <li><a href="../auth/logout.php">Đăng xuất</a></li>
    </ul>
</body>
</html>
