<!-- Hiển thị kết quả tìm kiếm sản phẩm -->
<div class="results">
    <?php if (!empty($searchResults)): ?>
        <h2>Kết quả tìm kiếm:</h2>
        <div class="card-container">
            <?php foreach ($searchResults as $result): ?>
                <div class="card">
                    <img src="assets/images/products/<?php echo htmlspecialchars($result['image_url']); ?>" alt="<?php echo htmlspecialchars($result['name']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($result['name']); ?></h3>
                        <p>Giá: $<?php echo htmlspecialchars($result['price']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_GET['search'])): ?>
        <h2>Không tìm thấy kết quả phù hợp.</h2>
    <?php endif; ?>
</div>
