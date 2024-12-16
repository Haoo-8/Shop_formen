<?php
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Product.class.php';

$db = new Db();
$product = new Product($db);

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $productDetails = $product->getProductDetail($productId);
    if ($productDetails) {
        echo json_encode($productDetails);
    } else {
        echo json_encode(['error' => 'Sản phẩm không tồn tại']);
    }

}else {
    echo json_encode(['error' => 'Không có product_id']);
}

?>

