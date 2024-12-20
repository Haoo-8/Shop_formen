<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Cart.class.php';
require_once '../classes/Product.class.php';
$db = new Db();
$response = ['status' => 'error', 'message' => 'An error occurred.'];

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    $response['message'] = 'Please log in to add products to cart.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($productId <= 0 || $quantity <= 0) {
        $response['message'] = 'Invalid data.';
        echo json_encode($response);
        exit;
    }

    $cart = new Cart();
    $productClass = new Product($db);

    // Kiểm tra sản phẩm có tồn tại
    $product = $productClass->getProductById2($productId);
    if (!$product) {
        $response['message'] = 'Product does not exist.';
        echo json_encode($response);
        exit;
    }

    // Thêm vào giỏ hàng
    $cart->addToCart($productId, $quantity);
    $response = [
        'status' => 'success',
        'message' => 'The product has been added to the cart.',
        'cart_total_quantity' => $cart->getTotalQuantity(),
        'cart_total_price' => number_format($cart->getTotalPrice($productClass), 0, ',', '.')
    ];
}

echo json_encode($response);
exit;
?>