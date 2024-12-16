<style>
    /* CSS cho header */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
    }

    .logo a {
        color: #fff;
        text-decoration: none;
        font-size: 24px;
        font-weight: bold;
    }

    .nav-links ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .nav-links ul li {
        margin: 0 15px;
    }

    .nav-links ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
    }

    .header-right {
        display: flex;
        align-items: center;
    }

    .search-box {
        margin-right: 20px;
    }

    .search-box input {
        padding: 5px;
        border: none;
        border-radius: 4px;
    }

    .icons a {
        margin-left: 15px;
    }

    .icons img {
        width: 24px;
        height: 24px;
    }
</style>
<header class="admin-header">
    <div class="logo">
        <a href="index.php">Admin Dashboard</a>
    </div>
    <nav class="nav-links">
        <ul>
            <li><a href="index.php?ac=dashboard">Dashboard</a></li>
            <li><a href="index.php?ac=manage_products">Quản lý sản phẩm</a></li>
            <li><a href="index.php?ac=manage_categories">Quản lý danh mục</a></li>
            <li><a href="index.php?ac=manage_orders">Quản lý đơn hàng</a></li>
            <li><a href="index.php?ac=manage_users">Quản lý người dùng</a></li>
            <li><a href="report/report.php">Báo cáo doanh thu</a></li>
        </ul>
    </nav>
    <div class="header-right">
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm thông tin..." />
        </div>
        <?php
        include 'notification_dropdown.php';
        ?>
        <div class="icons">
            <a href="../auth/logout.php"><img src="../../assets/images/icons/log_out.png" alt="Đăng xuất"></a>
        </div>
    </div>
</header>