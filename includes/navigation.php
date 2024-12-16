<nav class="main-nav">
    <ul>
        <li><a href="index.php?ac="><span style="color: orange;">-50% </span><span>OUTLET</span></a></li>
        <li>
            <a href="index.php?ac=product_list">SẢN PHẨM</a>
            <ul class="sub-menu">
                <?php
                foreach ($categories as $cat): ?>

                    <li>
                        <a href="view_category.php?id=<?php echo urlencode($cat['category_id']) ?>"><?php echo htmlspecialchars($cat['category_name']); ?></a>
                    </li>

                <?php endforeach;
                ?>
            </ul>
        </li>

        <li><a href="contact.php">BLOG</a></li>
        <li><a href="contact.php">SẢN XUÂT RIÊNG</a></li>
        <li><a href="contact.php">CARE &amp; SHARE</a></li>
    </ul>
</nav>