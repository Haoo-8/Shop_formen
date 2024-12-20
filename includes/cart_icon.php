<?php
require_once 'classes/Cart.class.php';

$cart = new Cart();
$totalQuantity = $cart->getTotalQuantity();
?>

<div class="cart-icon">
    <a href="views/cart.php"><img src="assets/images/icons/cart.png" alt="Icon-cart"></a>
    <span class="cart-count"><?php echo $totalQuantity; ?></span>
</div>
