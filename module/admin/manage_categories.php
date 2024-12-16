<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Category.class.php';

$db = new Db();
$category = new Category($db);

// Xử lý yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    if ($action === 'delete' && $id > 0) {
        $category->deleteCategory($id);
    } elseif ($action === 'add' || $action === 'edit') {
        $name = trim($_POST['category_name']);
        $description = trim($_POST['description']);

        if ($action === 'add') {
            $category->addCategory($name, $description);
        } elseif ($action === 'edit' && $id > 0) {
            $category->updateCategory($id, $name, $description);
        }
    }
}

// Lấy danh sách danh mục
$categories = $category->getAllCategories();
?>

<h1>Quản lý danh mục</h1>
<div class="category-list">
    <?php foreach ($categories as $cat): ?>
        <div class="category-item">
            <h3><?php echo htmlspecialchars($cat['category_name']); ?></h3>
            <p><?php echo htmlspecialchars($cat['description']); ?></p>
            <form action="manage_categories.php" method="post" style="display: inline-block;">
                <input type="hidden" name="category_id" value="<?php echo $cat['category_id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit">Xóa</button>
            </form>
            <button onclick="editCategory(<?php echo $cat['category_id']; ?>, '<?php echo htmlspecialchars($cat['category_name']); ?>', '<?php echo htmlspecialchars($cat['description']); ?>')">Chỉnh sửa</button>
        </div>
    <?php endforeach; ?>
</div>

<button onclick="addCategory()">Thêm danh mục mới</button>

<script>
    function addCategory() {
        var name = prompt("Tên danh mục:");
        var description = prompt("Mô tả danh mục:");
        if (name && description) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'manage_categories.php';

            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'category_name';
            nameInput.value = name;
            form.appendChild(nameInput);

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

    function editCategory(id, currentName, currentDescription) {
        var name = prompt("Tên danh mục:", currentName);
        var description = prompt("Mô tả danh mục:", currentDescription);
        if (name && description) {
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'manage_categories.php';

            var idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'category_id';
            idInput.value = id;
            form.appendChild(idInput);

            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'category_name';
            nameInput.value = name;
            form.appendChild(nameInput);

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
</script>