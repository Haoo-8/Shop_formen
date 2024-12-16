<?php
require_once '../../../vendor/autoload.php';
require_once '../../../classes/Report.class.php';

use Dompdf\Dompdf;

// Khởi tạo class Report
$report = new Report();

// Lấy thông tin từ request
$startDate = $_POST['start_date'] ?? date('Y-01-01');
$endDate = $_POST['end_date'] ?? date('Y-m-d');

// Lấy dữ liệu từ class
$totalRevenue = $report->getTotalRevenue($startDate, $endDate);
$totalOrders = $report->getTotalOrders($startDate, $endDate);
$monthlyRevenue = $report->getMonthlyRevenue($startDate, $endDate);

// Tạo nội dung HTML
$html = "
    <h1>Báo cáo doanh thu</h1>
    <p>Tổng doanh thu: " . number_format($totalRevenue, 0, ',', '.') . " VND</p>
    <p>Tổng số đơn hàng: $totalOrders</p>
    <h2>Doanh thu từng tháng</h2>
    <table border='1' cellpadding='10'>
        <tr><th>Tháng</th><th>Doanh thu (VND)</th></tr>";
foreach ($monthlyRevenue as $data) {
    $html .= "<tr><td>Tháng " . $data['month'] . "</td><td>" . number_format($data['revenue'], 0, ',', '.') . "</td></tr>";
}
$html .= "</table>";

// Xuất PDF
// $dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("baocao_doanhthu.pdf", ["Attachment" => true]);
