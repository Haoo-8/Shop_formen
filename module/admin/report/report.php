<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo doanh thu</title>
    <link rel="stylesheet" href="../../../assets/css/report.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../assets/js/chart_config.js" del></script>
</head>

<body>
    <div class="container">
        <!-- Bộ lọc -->
        <div class="filter-form">
            <h2>Lọc báo cáo</h2>
            <form method="POST">
                <label for="start_date">Từ ngày:</label>
                <input type="date" name="start_date" value="<?php echo date('Y-01-01'); ?>" required>
                <label for="end_date">Đến ngày:</label>
                <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>" required>
            </form>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="statistics">
            <h2>Thống kê tổng quan</h2>
            <div><strong>Tổng doanh thu:</strong> <span id="totalRevenue">0</span> </div>
            <div><strong>Tổng số đơn hàng:</strong> <span id="totalOrders">0</span></div>
            <div><strong>Tổng số sản phẩm đã bán:</strong> <span id="totalProducts">0</span></div>
        </div>

        <!-- Biểu đồ doanh thu -->
        <div class="chart-container">
            <h2>Doanh thu từng tháng</h2>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</body>

</html>