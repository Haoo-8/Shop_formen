<?php
require_once '../config/config.php';
require_once '../classes/Db.class.php';
require_once '../classes/Cart.class.php';

session_start();


$cart = new Cart();

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'];
$productId = intval($data['product_id']);
$quantity = isset($data['quantity']) ? intval($data['quantity']) : 0;

$response = ["success" => false, "message" => ""];
if ($action === "update") {
    $cart->updateCart($productId, $quantity);
    $response["success"] = true;
} elseif ($action === "remove") {
    $cart->removeFromCart($productId);
    $response["success"] = true;
}

echo json_encode($response);
