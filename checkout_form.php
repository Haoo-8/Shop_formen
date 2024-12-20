<form id="checkout-form" method="POST" action="checkout.php">
    <label>Họ và tên:</label>
    <input type="text" name="customer_name" required>

    <label>Email:</label>
    <input type="email" name="customer_email" required>

    <label>Số điện thoại:</label>
    <input type="text" name="customer_phone" required>

    <label>Địa chỉ giao hàng:</label>
    <textarea name="shipping_address" required></textarea>

    <label>Phương thức thanh toán:</label>
    <select name="payment_method">
        <option value="COD">Thanh toán khi nhận hàng (COD)</option>
        <option value="Bank">Chuyển khoản ngân hàng</option>
    </select>

    <button type="submit">Thanh toán</button>
</form>

<script>
document.getElementById('checkout-form').onsubmit = async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('/DA_Web/actions/checkout.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.json();
    alert(result.message);
    if (result.status === 'success') {
        window.location.href = 'order_success.php';
    }
};
</script>
