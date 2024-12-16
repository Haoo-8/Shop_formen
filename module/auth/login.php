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
        // Truy vấn thông tin người dùng từ cơ sở dữ liệu
        $_isUser = $db->select("SELECT * FROM users WHERE username = ?", [$username]);

        if ($_isUser && password_verify($password, $_isUser[0]['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $_isUser[0]['user_id'];
            $_SESSION['role'] = $_isUser[0]['role']; // Đảm bảo rằng vai trò cũng được lưu
            header("Location: ../../index.php");
            exit;
        } else {
            $_SESSION['error'] = "Sai tài khoản hoặc mật khẩu.";
        }
    }
}
?>
