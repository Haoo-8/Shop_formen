<?php
require_once '../../../config/config.php';
require_once '../../../classes/Db.class.php';
require_once '../../../classes/Report.class.php';
// Khởi tạo class
$report = new Report();

// Lấy thông tin từ AJAX request
$startDate = $_POST['start_date'] ?? date('Y-01-01');
$endDate = $_POST['end_date'] ?? date('Y-m-d');

// Kiểm tra đầu vào 
if (!isset($_POST['start_date']) || !isset($_POST['end_date'])) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}
// Gọi phương thức lấy dữ liệu
$totalRevenue = $report->getTotalRevenue($startDate, $endDate);
$totalOrders = $report->getTotalOrders($startDate, $endDate);
$totalProducts = $report->getTotalProducts($startDate, $endDate);
$monthlyRevenue = $report->getMonthlyRevenue($startDate, $endDate);

// Log dữ liệu để kiểm tra 
error_log("Total Revenue: $totalRevenue, Total Orders: $totalOrders, Total Products: $totalProducts");
// Trả dữ liệu về cho client
echo json_encode([
    'total_revenue' => $totalRevenue,
    'total_orders' => $totalOrders,
    'total_products' => $totalProducts,
    'monthly_revenue' => $monthlyRevenue,
]);
