<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Cart.class.php';

$db = new Db();
$cart = new Cart($db);


// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Ban can dang nhap de them san pham vao gio hang.']);
    exit;
}

$userId = $_SESSION['user_id'];
$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Thêm sản phẩm vào giỏ hàng
$cart->addToCart($userId, $productId, $quantity);
echo json_encode(['status' => 'success', 'message' => 'San pham da duoc them vao gio hang!']);
?>
