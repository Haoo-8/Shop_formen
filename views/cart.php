<?php
require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Product.class.php';
require_once '../classes/Cart.class.php';

session_start();

$db = new Db();
$product = new Product($db);
$cart = new Cart();

$cartItems = $cart->getCartItems($product);
$totalPrice = $cart->getTotalPrice($product);
print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main>
        <h1>Giỏ hàng của bạn</h1>
        <div class="cart-container">
            <?php if (!empty($cartItems)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                <td>
                                    <input type="number" value="<?php echo $item['quantity']; ?>" 
                                           data-product-id="<?php echo $item['product_id']; ?>" 
                                           class="update-quantity">
                                </td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                                <td>
                                    <button  data-product-id="<?php echo $item['product_id']; ?>" class="remove-item">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <strong>Tổng cộng:</strong> <?php echo number_format($totalPrice, 0, ',', '.'); ?> VND
                </div>
                <button class="checkout-button"><a href="../checkout_form.php">Thanh toán</a></button>
            <?php else: ?>
                <p>Giỏ hàng của bạn đang trống.</p>
            <?php endif; ?>
        </div>
    </main>

    <script src="../assets/js/cart.js"></script>
</body>
</html>
