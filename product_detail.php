<?php
require_once 'config/config.php';
require_once 'classes/Db.class.php';
require_once 'classes/Product.class.php';
require_once 'includes/breadcrumb.php';

// Kết nối database và khởi tạo class Product
$db = new Db();
$product = new Product($db);

// Lấy id sản phẩm từ URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra sản phẩm có tồn tại
$currentProduct = $product->getProductById2($productId);
if (!$currentProduct) {
    die("Sản phẩm không tồn tại.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($currentProduct['name']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php
        renderBreadcrumb();
    ?>
    <main>
        <h1><?php echo htmlspecialchars($currentProduct['name']); ?></h1>
        <div class="product-detail">
            <div class="product-image">
                <img src="assets/images/products/<?php echo htmlspecialchars($currentProduct['image_url']); ?>" alt="<?php echo htmlspecialchars($currentProduct['name']); ?>">
            </div>
            <div class="product-info">
                <p><strong>Giá:</strong> <?php echo number_format($currentProduct['price'], 0, ',', '.'); ?> VND</p>
                <p><strong>Mô tả:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($currentProduct['description'])); ?></p>
                <form method="POST" action="actions/ajax_add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $currentProduct['product_id']; ?>">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                    <button onclick="addToCart(1, 1)">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
