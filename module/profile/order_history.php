<?php
session_start();
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Order.class.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$db = new Db();
$order = new Order($db);
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE customer_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Lịch sử đơn hàng</h1>
<?php foreach ($orders as $order): ?>
    <p>Đơn hàng #<?php echo $order['order_id']; ?> - Tổng tiền: <?php echo $order['total_price']; ?> VNĐ</p>
<?php endforeach; ?>
<a href="profile.php">Quay lại hồ sơ</a>
