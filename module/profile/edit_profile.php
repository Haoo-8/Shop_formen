<?php
session_start();
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index");
    exit;
}

$db = new Db();
$user = new User($db);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone_number = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    // Cập nhật thông tin người dùng
    $result = $user->updateUserInfo( $full_name, $phone_number, $address, $user_id);

    if ($result) {
        // Cập nhật thông tin trong session nếu cần thiết
        $_SESSION['fullname'] = $full_name;
        $_SESSION['phone'] = $phone_number;
        $_SESSION['address'] = $address;

        header("Location: profile.php");
        exit;
    } else {
        $_SESSION['error'] = "Cập nhật thông tin thất bại.";
    }
}

// Truy vấn thông tin hiện tại của người dùng
$sql = "SELECT fullname, phone, address FROM users WHERE user_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa hồ sơ</title>
</head>

<body>
    <h1>Chỉnh sửa thông tin cá nhân</h1>
    <form method="POST" action="">
        <label>Họ và tên:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

        <label>Địa chỉ:</label>
        <textarea name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

        <button type="submit">Lưu thông tin</button>
    </form>
    <a href="profile.php">Quay lại hồ sơ</a>
</body>

</html>