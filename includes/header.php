<?php
require_once 'config/config.php';
require_once 'classes/Db.class.php';
require_once 'classes/Product.class.php';
require_once 'classes/User.class.php';
include ROOT . "/includes/functions.php";
spl_autoload_register("loadClass");
session_start();

$db = new Db();
$category = new Category($db);
$categories = $category->getAllCategories();
$product = new Product($db);
$user = new User($db);
print_r($_SESSION);

$searchResults = [];
if (isset($_GET['search']) && $_GET['search']) {
    $searchTerm = $_GET['search'];
    $searchResults = $product->searchProduct($searchTerm);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DA VO NHAT HAO</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <header class="site-header">
        <div class="topbar">
            <div>
                <ul class="main-nav">
                    <li><a href=""><img src="assets/images/Cl.png" alt="logo-hah"></a></li>
                    <li><a href=""><img src="assets/images/CN.png" alt="logo-84hah"></a></li>
                    <li><a href=""><img src="assets/images/Pl.png" alt="log-xhah"></a></li>
                </ul>
            </div>
            <div>
                <ul class="main-nav">
                    <li><a href="">Tham gia Hah Club</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Về Hah</a></li>
                    <li><a href="">Trung tâm CSKH</a></li>
                    <li><a href="module/admin/index.php">Admin</a></li>
                </ul>
            </div>
        </div>
        <div class="topbar-promotion">
            <div><a href="">
                    <div><span>Áo thu đông đa dạng sự lựa chọn</span> <span>Mua ngay</span></div>
                </a></div>

        </div>
        <div class="header ">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/images/H.png" alt="Logo Trang Web">
                </a>
            </div>
            <!-- Menu điều hướng -->
            <?php include 'navigation.php'?>

            <?php include 'search.php'?>
            <?php include 'cart.php'?>
            <nav class="nav-container__login">
                <ul> <?php if (isset($_SESSION['username'])) { ?>
                        <li><a href="module/auth/profile.php">Xin chào,
                                <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                        </li>
                        <li><a href="module/auth/logout.php">Đăng xuất</a></li>
                    <?php
                        } else { ?> <li><a href="#" id="userIcon"><img src="assets/images/icons/person.png" alt="Icon-user" class="icon-user"></a></li> <?php } ?>
                </ul>
            </nav>
            <!-- Hộp thoại đăng nhập/đăng ký -->
            <?php include 'user_modal.php' ?>
            <script>
                // Get the modal 
                var modal = document.getElementById("userModal"); // Get the button that opens the modal 
                var btn = document.getElementById("userIcon"); // Get the <span> element that closes the modal 
                var span = document.getElementsByClassName("close-btn")[0]; // When the user clicks the button, open the modal 

                var loginForm = document.getElementById("loginForm");
                var registerForm = document.getElementById("registerForm");
                var switchToRegister = document.getElementById("switchToRegister");
                var switchToLogin = document.getElementById("switchToLogin");

                btn.onclick = function() {
                    modal.style.display = "block";
                } // When the user clicks on <span> (x), close the modal 
                span.onclick = function() {
                    modal.style.display = "none";
                } // When the user clicks anywhere outside of the modal, close it 
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                switchToRegister.onclick = function() {
                    loginForm.classList.remove("active");
                    registerForm.classList.add("active");
                    document.getElementById("modalTitle").innerHTML = "Đăng ký tài khoản để nhận nhiều ưu đãi";
                }

                switchToLogin.onclick = function() {
                    registerForm.classList.remove("active");
                    loginForm.classList.add("active");
                    document.getElementById("modalTitle").innerText = "Rất nhiều đặc quyền và quyền lợi mua sắm đang chờ bạn";
                }
            </script>
            <script>
                // Thay đổi màu chữ và hình ảnh của ảnh logo khi hover
                var logo = document.querySelector('.logo img');
                logo.addEventListener('mouseover', function() {
                    logo.src = 'assets/images/H_hover.png';
                    logo.style.transition = 'all 0.5s';
                });

                logo.addEventListener('mouseout', function() {
                    logo.src = 'assets/images/H.png';
                    logo.style.transition = 'all 0.5s';
                });
            </script>
        </div>
        </div>
    </header>

</body>

</html>