<?php
class ProductVariant extends Db {
    // Lấy tất cả biến thể sản phẩm
    public function getAllProductVariants() {
        $sql = "SELECT * FROM productvariants";
        return $this->select($sql);
    }

    // Lấy biến thể sản phẩm theo ID sản phẩm
    public function getProductVariantsByProductId($productId) {
        $sql = "SELECT * FROM productvariants WHERE product_id = ?";
        return $this->select($sql, [$productId]);
    }

    // Thêm biến thể sản phẩm mới
    public function addProductVariant($productId, $sizeId, $colorId, $stockQuantity) {
        $sql = "INSERT INTO productvariants (product_id, size_id, color_id, stock_quantity) VALUES (?, ?, ?, ?)";
        return $this->insert($sql, [$productId, $sizeId, $colorId, $stockQuantity]);
    }

    // Cập nhật biến thể sản phẩm
    public function updateProductVariant($variantId, $sizeId, $colorId, $stockQuantity) {
        $sql = "UPDATE productvariants SET size_id = ?, color_id = ?, stock_quantity = ? WHERE variant_id = ?";
        return $this->update($sql, [$sizeId, $colorId, $stockQuantity, $variantId]);
    }

    // Xóa biến thể sản phẩm
    public function deleteProductVariant($variantId) {
        $sql = "DELETE FROM productvariants WHERE variant_id = ?";
        return $this->delete($sql, [$variantId]);
    }
}
?>
