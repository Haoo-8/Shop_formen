document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const quantity = 1;

        fetch('actions/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                updateCartCount();
            } else {
                alert(data.message);
            }
        });
    });
});

function updateCartCount() {
    // Gửi yêu cầu đến server để lấy số lượng sản phẩm trong giỏ hàng
    fetch('actions/get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Tìm phần tử hiển thị số lượng giỏ hàng trên giao diện
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    // Cập nhật số lượng hiển thị
                    cartCountElement.textContent = data.cartCount;
                }
            } else {
                console.error('Không thể cập nhật số lượng giỏ hàng:', data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật số lượng giỏ hàng:', error);
        });
}

