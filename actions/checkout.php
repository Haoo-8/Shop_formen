<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Cart.class.php';
require_once '../classes/Product.class.php';
require_once '../classes/Order.class.php';

$db = new Db();
$cart = new Cart();
$productClass = new Product($db);
$orderClass = new Order($db);

$response = ['status' => 'error', 'message' => 'Có lỗi xảy ra.'];

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    $response['message'] = 'Vui lòng đăng nhập để thanh toán.';
    echo json_encode($response);
    exit;
}

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $customerId = $_SESSION['user_id'];
    $customerName = trim($_POST['customer_name']);
    $customerEmail = trim($_POST['customer_email']);
    $customerPhone = trim($_POST['customer_phone']);
    $shippingAddress = trim($_POST['shipping_address']);
    $paymentMethod = trim($_POST['payment_method']); // COD, Bank, etc.
    $totalPrice = $cart->getTotalPrice($productClass);

    // Kiểm tra giỏ hàng có rỗng không
    if ($totalPrice <= 0) {
        $response['message'] = 'Giỏ hàng trống. Vui lòng thêm sản phẩm.';
        echo json_encode($response);
        exit;
    }

    // Tạo đơn hàng
    $result = $orderClass->createOrder($customerId, $customerName, $customerEmail, $customerPhone, $shippingAddress, $totalPrice, $paymentMethod);
    
    if ($result) {
        // Xóa giỏ hàng sau khi thanh toán thành công
        $cart->clearCart();

        $response = [
            'status' => 'success',
            'message' => 'Thanh toán thành công. Đơn hàng đang được xử lý.',
            'order_total' => number_format($totalPrice, 0, ',', '.') . ' VND'
        ];
    } else {
        $response['message'] = 'Không thể tạo đơn hàng. Vui lòng thử lại.';
    }
}

echo json_encode($response);
exit;
?>
