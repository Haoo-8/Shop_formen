<?php

class Cart extends Db{
    public function __construct() {
        // Kiểm tra nếu giỏ hàng chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart($productId, $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function updateCart($productId, $quantity) {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function getCartItems($productClass) {
        $items = [];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            //Chú ý hàm getProductById2 ở đây sẽ trả về mảng khác với hàm trùng tên kia trả về select
            $product = $productClass->getProductById2($productId);  
            if ($product) {
                $product['quantity'] = $quantity;
                $items[] = $product;
            }
        }
        return $items;
    }

    public function getTotalQuantity() {
        return array_sum($_SESSION['cart']);
    }

    public function getTotalPrice($productClass) {
        $total = 0;
        foreach ($this->getCartItems($productClass) as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    public function getCartAsJson($productClass) {
        $cartItems = $this->getCartItems($productClass);
        return json_encode([
            'items' => $cartItems,
            'total_quantity' => $this->getTotalQuantity(),
            'total_price' => $this->getTotalPrice($productClass)
        ]);
    }

}
