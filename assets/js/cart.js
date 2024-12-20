// Thêm sản phẩm vào giỏ hàng
const baseUrl = `${window.location.origin}/DA_Web/`;

function addToCart(productId, quantity) {
    $.ajax({
        url: 'actions/ajax_add_to_cart.php',
        method: 'POST',
        data: { product_id: productId, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
                updateCartSummary(response.cart_total_quantity, response.cart_total_price);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Có lỗi xảy ra.');
        }
    });
}

// Cập nhật giỏ hàng
function updateCart(productId, quantity) {
    $.ajax({
        url: 'actions/ajax_update_cart.php',
        method: 'POST',
        data: { product_id: productId, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
                updateCartSummary(response.cart_total_quantity, response.cart_total_price);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Có lỗi xảy ra.');
        }
    });
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(productId) {
    $.ajax({
        url: 'actions/ajax_remove_from_cart.php',
        method: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
                updateCartSummary(response.cart_total_quantity, response.cart_total_price);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Có lỗi xảy ra.');
        }
    });
}

// Cập nhật giao diện tổng giỏ hàng
function updateCartSummary(totalQuantity, totalPrice) {
    $('.cart-count').text(totalQuantity);
    $('.cart-total').text(totalPrice + ' VND');
}


document.addEventListener("DOMContentLoaded", () => {
    const updateQuantityInputs = document.querySelectorAll(".update-quantity");
    const removeButtons = document.querySelectorAll(".remove-item");
    // Cập nhật số lượng
    updateQuantityInputs.forEach(input => {
        input.addEventListener("change", () => {
            const productId = input.dataset.productId;
            const quantity = input.value;

            fetch("actions/ajax_update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "update", product_id: productId, quantity: quantity })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || "Đã xảy ra lỗi!");
                }
            });
        });
    });
    
    // Xóa sản phẩm
    removeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productId = button.dataset.productId;
            
            fetch("/DA_Web/actions/ajax_update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "remove", product_id: productId })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || "Đã xảy ra lỗi!");
                }
            });
        });
    });
});
