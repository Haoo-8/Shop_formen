<?php
require_once 'authAdmin/auth.php';

include '../../includes/header_admin.php';
include '../../includes/sidebar_admin.php';

// Lấy giá trị action từ URL, sử dụng filter để chống tấn công XSS 
$ac = isset($_GET['ac']) ? filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : 'dashboard';
echo '<main>';
switch ($ac) {
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'manage_users':
        include 'manage_users.php';
        break;

    case 'manage_categories':
        include 'manage_categories.php';
        break;
    case 'manage_products':
        include 'manage_products.php';
        break;
    case 'manage_orders':
        include 'manage_orders.php';
        break;
    case 'report':
        include 'report.php';
        break;
    default:
        include 'dashboard.php';
        break;
}
echo '</main>';
include '../../includes/footer_admin.php';
