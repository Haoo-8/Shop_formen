<?php // auth/register.php 
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/User.class.php';
session_start(); // Initialize database and User class 
$db = new Db();
$user = new User($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']); // Validate input 
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';
    if (empty($username) || empty($password) || empty($phone) || empty($email)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email không hợp lệ.";
        header('Location: ../../index.php');
        exit; 
    } elseif ($user->checkUsernameExists($username)) {
        $_SESSION['error'] = "Tên đăng nhập đã tồn tại.";
        header('Location: ../../index.php');
        exit; 
    } elseif ($user->checkEmailExists($email)) {
        $_SESSION['error'] = "Email đã tồn tại.";
        header('Location: ../../index.php');
        exit; 
    } else {
        try {
            $user->register($username, $password, $email, $phone, $role );
            $_SESSION['success'] = "Đăng ký thành công!";
            header('Location: ../../index.php');
            exit;   
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
}
?>
