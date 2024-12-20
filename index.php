<?php
require_once 'config/config.php';
require_once 'classes/Db.class.php';
require_once 'classes/Product.class.php';
require_once 'classes/Category.class.php';
require_once 'classes/Color.class.php';
require_once 'classes/Size.class.php';
require_once 'includes/breadcrumb.php';



$db = new Db();
$product = new Product($db);
$category = new Category($db);
$color = new Color($db);
$size = new Size($db);

// Lấy danh sách sản phẩm nổi bật hoặc mới
$featuredProducts = $product->getAllProducts();

// Lấy danh sách danh mục sản phẩm
$categories = $category->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DA VO NHAT HAO</title>

</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <!-- Main Content Section -->
    <main class="main-content">
        <!-- Promotion Slider -->
        <div class="promotion-slider">
            <div class="slider">
                <div class="slide active"><img src="assets/images/Hero_Banner.jpg" alt="Khuyến mãi mùa thu"></div>
                <div class="slide"><img src="assets/images/Sale_Banner.jpg" alt="Sale lên đến 50%"></div>
                <div class="slide"><img src="assets/images/Hero_Child.jpg" alt="Sản phẩm mới nhất"></div>
            </div>
            <button class="prev-banner" onclick="prevSlide()">&#10094;</button>
            <button class="next-banner" onclick="nextSlide()">&#10095;</button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const slides = document.querySelectorAll(".slide");
                let currentIndex = 0;

                function updateSlides() {
                    slides.forEach((slide, index) => {
                        slide.classList.remove("active");
                        if (index === currentIndex) {
                            slide.classList.add("active");
                        }
                    });

                    // Cập nhật vị trí các slide
                    const slider = document.querySelector(".slider");
                    const offset = -currentIndex * 100; // Chuyển đổi slide bằng phần trăm
                    slider.style.transform = `translateX(${offset}%)`;
                }

                function prevSlide() {
                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
                    updateSlides();
                }

                function nextSlide() {
                    currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
                    updateSlides();
                }

                // Gán sự kiện cho các nút điều hướng
                document.querySelector(".prev-banner").addEventListener("click", prevSlide);
                document.querySelector(".next-banner").addEventListener("click", nextSlide);

                // Tự động chuyển slide mỗi 5 giây (nếu cần)
                setInterval(nextSlide, 5000); // Xóa dòng này nếu không muốn tự động
            });
        </script>
        <?php
        renderBreadcrumb();
        ?>
        <!-- Categories Section -->
        <section class="categories">
            <h2>Danh Mục Sản Phẩm</h2>
            <ul class="category-list">
                <?php foreach ($categories as $cat) { ?>
                    <li><a href="category.php?id=<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></a></li>
                <?php } ?>
            </ul>
        </section>

        <!-- Featured Products Section -->
        <section class="featured-products">
            <h2>Sản Phẩm Nổi Bật</h2>
            <div class="slider-container">
                <button class="prev" onclick="prevSlide()">&#10094;</button>
                <div class="products-container">
                    <?php foreach ($featuredProducts as $productItem):
                        $productId = $productItem['product_id'];
                        $sizes = $product->getSizesForProduct($productId);
                        $colors = $product->getColorsForProduct($productId);
                    ?>
                        <div class="product-card">
                            <div class="product-card-inner">
                                <!-- Hình ảnh sản phẩm -->
                                <div class="product-image">
                                    <img src="assets/images/products/<?php echo htmlspecialchars($productItem['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($productItem['name']); ?>">
                                </div>
                                <!-- Nội dung sản phẩm -->
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($productItem['name']); ?></h3>
                                    <p>Giá: <?php echo number_format($productItem['price'], 0, ',', '.'); ?>$</p>
                                </div>

                                <!-- Nút thao tác hiển thị khi hover -->
                                <div class="product-actions">
                                    <button class="btn-add-to-cart" onclick="addToCart('<?php echo $productItem['product_id']; ?>', 1)">
                                        <i class="icon-cart"></i> Thêm vào giỏ
                                    </button>

                                    <button class="btn-view-details" onclick="openPopup('<?php echo $productId; ?>')">
                                        <i class="icon-eye"></i>
                                        <img style="width: 30px; height: 30px;" src="assets/images/icons/eye.png" alt="icon_eyes">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Popup chi tiết sản phẩm -->
                        <div id="product-popup" class="popup-overlay">
                            <div class="popup-content">
                                <!-- Nút đóng popup -->
                                <button class="popup-close" onclick="closePopup()">&times;</button>
                                <div class="popup-container1">
                                    <!-- Hình ảnh sản phẩm -->
                                    <div class="popup-image">
                                        <img id="popup-product-image" src="" alt="Sản phẩm">
                                    </div>
                                    <!-- Chi tiết sản phẩm -->
                                    <div class="popup-details">
                                        <h3 id="popup-product-name"></h3>
                                        <p>Mã sản phẩm: <span id="popup-product-id"></span></p>
                                        <p>Giá: <span id="popup-product-price"></span></p>
                                        <p>
                                            <strong>Màu sắc:</strong>
                                        <div id="popup-product-colors" class="popup-options"></div>
                                        </p>
                                        <p>
                                            <strong>Kích thước:</strong>
                                        <div id="popup-product-sizes" class="popup-options"></div>
                                        </p>
                                        <!-- <input type="hidden" name="product_id" value="<?php echo $productItem['product_id']; ?>"> -->
                                        <label for="quantity popup-quantity">Số lượng:</label>
                                        <input type="number" name="quantity" id="quantity popup-quantity" min="1" value="1">
                                        <button class="btn-add-to-cart" onclick="addToCart('<?php echo $productItem['product_id']; ?>', 1)">
                                            <i class="icon-cart"></i> Thêm vào giỏ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <button class="next" onclick="nextSlide()">&#10095;</button>
                <script>
                    function openPopup(productId) {
                        // Hiển thị overlay trong lúc tải dữ liệu
                        document.getElementById('product-popup').style.display = 'flex';

                        // Gửi request AJAX để lấy thông tin sản phẩm
                        fetch(`module/product/detail.php?product_id=${productId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                    closePopup();
                                } else {
                                    // Điền dữ liệu vào popup
                                    document.getElementById('popup-product-name').textContent = data.name;

                                    // Kiểm tra và gán hình ảnh
                                    const productImage = document.getElementById('popup-product-image');
                                    if (data.image_url) {
                                        productImage.src = `assets/images/products/${data.image_url}`;
                                        productImage.alt = data.name;
                                    } else {
                                        productImage.src = '';
                                        productImage.alt = 'Hình ảnh không tồn tại';
                                    }

                                    document.getElementById('popup-product-price').textContent = `${data.price.toLocaleString()}$`;

                                    // Hiển thị danh sách màu sắc
                                    const colorContainer = document.getElementById('popup-product-colors');
                                    colorContainer.innerHTML = '';
                                    data.colors.forEach(color => {
                                        const colorSpan = document.createElement('span');
                                        colorSpan.classList.add('color-swatch');
                                        if (color.color_code) {
                                            colorSpan.style.backgroundColor = color.color_code; // Hiển thị mã màu nếu có
                                        }
                                        colorContainer.appendChild(colorSpan);
                                    });

                                    // Hiển thị danh sách kích thước
                                    const sizeContainer = document.getElementById('popup-product-sizes');
                                    sizeContainer.innerHTML = '';
                                    const sizes = Array.isArray(data.sizes) ? data.sizes : data.sizes.split(',');
                                    sizes.forEach(size => {
                                        const sizeSpan = document.createElement('span');
                                        sizeSpan.textContent = size; // Hiển thị tên kích thước
                                        sizeContainer.appendChild(sizeSpan);
                                    });

                                    // Cập nhật ID sản phẩm
                                    document.getElementById('popup-product-id').textContent = productId;
                                }
                            })
                            .catch(error => {
                                console.error('Có lỗi xảy ra khi tải dữ liệu sản phẩm!', error);
                                closePopup();
                            });
                    }

                    function closePopup() {
                        document.getElementById('product-popup').style.display = 'none';
                    }
                </script>
        </section>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const productsContainer = document.querySelector(".products-container");
                const productCards = document.querySelectorAll(".product-card");
                const productCardWidth = productCards[0].offsetWidth; // Lấy chiều rộng của một sản phẩm
                const totalProducts = productCards.length;
                const visibleProducts = 5; // Số sản phẩm hiển thị cùng lúc
                let currentIndex = 0;

                function updateSlider() {
                    const offset = -currentIndex * productCardWidth; // Dịch chuyển dựa trên chiều rộng sản phẩm
                    productsContainer.style.transform = `translateX(${offset}px)`;
                }

                function prevSlide() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSlider();
                    }
                }

                function nextSlide() {
                    if (currentIndex < totalProducts - visibleProducts) {
                        currentIndex++;
                        updateSlider();
                    }
                }

                // Gán sự kiện cho các nút
                document.querySelector(".prev").addEventListener("click", prevSlide);
                document.querySelector(".next").addEventListener("click", nextSlide);
            });
        </script>
        <?php
        include "./module/search/search_result.php"
        ?>
    </main>
    <?php
    include "includes/footer.php";
    ?>
</body>

</html>