<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Product.class.php';
require_once '../../classes/Category.class.php';
require_once '../../classes/User.class.php';

// Khởi tạo các đối tượng
$db = new Db();
$product = new Product($db);
$category = new Category($db);
$user = new User($db);

// Lấy tổng số liệu
$totalProducts = $product->getProductCount();
$totalCategories = $category->getCategoryCount();
$totalUsers = $user->getUserCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .container {
            margin: 20px;
        }
        .dashboard-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            text-align: center;
        }
        .dashboard-card h3 {
            margin: 0;
            font-size: 24px;
        }
        .dashboard-card p {
            font-size: 18px;
            margin: 10px 0;
        }
        .dashboard-buttons {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .dashboard-buttons a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .dashboard-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
</header>
<div class="container">
    <!-- Section hiển thị tổng quan -->
    <div class="dashboard-card">
        <h3>Thống kê nhanh</h3>
        <p><strong>Tổng số sản phẩm:</strong> <?php echo $totalProducts; ?></p>
        <p><strong>Tổng số danh mục:</strong> <?php echo $totalCategories; ?></p>
        <p><strong>Tổng số người dùng:</strong> <?php echo $totalUsers; ?></p>
    </div>

    <!-- Section nút điều hướng -->
    <div class="dashboard-buttons">
        <a href="manage_products.php">Quản lý sản phẩm</a>
        <a href="manage_categories.php">Quản lý danh mục</a>
        <a href="manage_users.php">Quản lý người dùng</a>
        <a href="manage_orders.php">Quản lý đơn hàng</a>
        <a href="report/report.php">Báo cáo doanh thu</a>
        <a href="settings.php">Cài đặt hệ thống</a>
    </div>
</div>
</body>
</html>
