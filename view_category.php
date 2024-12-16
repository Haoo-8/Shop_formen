<?php
require_once 'config/config.php';
require_once 'classes/Db.class.php';
require_once 'classes/Product.class.php';
require_once 'classes/Category.class.php';

// Kết nối database và khởi tạo các class
$db = new Db();
$product = new Product($db);
$category = new Category($db);

// Lấy id danh mục từ URL
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra danh mục có tồn tại
$currentCategory = $category->getCategoryById($categoryId);
if (!$currentCategory) {
    die("Danh mục không tồn tại.");
}
// Lấy danh sách sản phẩm theo danh mục
$products = $product->getProductsByCategory($categoryId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($currentCategory['category_name']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <h1><?php echo htmlspecialchars($currentCategory['category_name']); ?></h1>
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="assets/images/products/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                        <a href="product_detail.php?id=<?php echo $product['product_id']; ?>">Xem chi tiết</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
