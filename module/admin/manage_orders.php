<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Order.class.php';

$db = new Db();
$order = new Order($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $orderId = intval($_POST['order_id']);

    if ($action === 'update_status') {
        $status = $_POST['status'];
        $order->updateOrderStatus($orderId, $status);
    } elseif ($action === 'delete' && $orderId > 0) {
        $order->deleteOrder($orderId);
    }

    header("Location: manage_orders.php");
    exit;
}

$orders = $order->getAllOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
</head>
<body>
    <h1>Quản lý đơn hàng</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng giá</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>$<?php echo $order['total_price']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="status">
                                <option value="Pending" <?php echo $order['order_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo $order['order_status'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Completed" <?php echo $order['order_status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="Cancelled" <?php echo $order['order_status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="action" value="update_status">Cập nhật</button>
                        </form>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" name="action" value="delete">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
