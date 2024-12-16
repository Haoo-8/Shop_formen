<div class="cart-icon">
    <a href="views/cart.php">
        <img src="assets/images/icons/cart.png" alt="Giỏ hàng">
    </a>
    <span class="cart-count">
        <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
    </span>
</div>
