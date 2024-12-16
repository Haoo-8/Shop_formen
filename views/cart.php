<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Cart.class.php';

$db = new Db();
$cart = new Cart($db);
print_r($_SESSION);
if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập để xem giỏ hàng.");
}

$userId = $_SESSION['user_id'];
$cartItems = $cart->getCart($userId);

?>

<h1>Giỏ hàng của bạn</h1>
<table>
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

