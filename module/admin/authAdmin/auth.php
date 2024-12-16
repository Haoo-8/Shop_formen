<?php
require_once dirname(__DIR__,3) . '/config/config.php';
require_once dirname(__DIR__, 3) . '/classes/Db.class.php';

require_once dirname(__DIR__, 3) .'/classes/User.class.php';
session_start();

$db = new Db();
$user = new User($db);

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./loginAdmin.php");
    exit;
}

?>