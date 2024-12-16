<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Product.class.php';


$db = new Db();
$product = new Product($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if ($action == 'delete' && $id > 0) {
        $product->deleteProduct($id);
    } elseif ($action == 'add' || $action == 'edit') {
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $description = trim($_POST['description']);
        if ($action == 'add') {
            $product->addProducts($name, $description, $price);
        } elseif ($action == 'edit' && $id > 0) {
            $product->updateProducts($id, $name, $description, $price);
        }
    }
}

$products = $product->getAllProducts();
?>

<h1>Quản lý sản phẩm</h1>
<div class="product-list">
    <?php foreach ($products as $product): ?>
        <div class="product-item">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p>Giá: $<?php echo htmlspecialchars($product['price']); ?></p>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <form action="manage_products.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit">Xóa</button>
            </form>
            <button onclick="editProduct(<?php echo $product['product_id']; ?>)">Chỉnh sửa</button>
        </div>
    <?php endforeach; ?>
</div>
<button onclick="addProduct()">Thêm sản phẩm mới</button>

<script>
    function addProduct() {
        var name = prompt("Tên sản phẩm:");
        var price = prompt("Giá sản phẩm:");
        var description = prompt("Mô tả sản phẩm:");
        if (name && price && description) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'manage_products.php';

            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'name';
            nameInput.value = name;
            form.appendChild(nameInput);

            var priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = 'price';
            priceInput.value = price;
            form.appendChild(priceInput);

            var descriptionInput = document.createElement('input');
            descriptionInput.type = 'hidden';
            descriptionInput.name = 'description';
            descriptionInput.value = description;
            form.appendChild(descriptionInput);

            var actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'add';
            form.appendChild(actionInput);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function editProduct(id) {
        var name = prompt("Tên sản phẩm:");
        var price = prompt("Giá sản phẩm:");
        var description = prompt("Mô tả sản phẩm:");
        if (name && price && description) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'manage_products.php';

            var idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'product_id';
            idInput.value = id;
            form.appendChild(idInput);

            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'name';
            nameInput.value = name;
            form.appendChild(nameInput);

            var priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = 'price';
            priceInput.value = price;
            form.appendChild(priceInput);

            var descriptionInput = document.createElement('input');
            descriptionInput.type = 'hidden';
            descriptionInput.name = 'description';
            descriptionInput.value = description;
            form.appendChild(descriptionInput);

            var actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'edit';
            form.appendChild(actionInput);

            document.body.appendChild(form);
            form.submit();
        }
    }
    form.onsubmit = function() {
        setTimeout(() => window.location.reload(), 500);
    };
</script>