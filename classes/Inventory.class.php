<?php
class Inventory extends Db{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function updateStock($productId, $stockQuantity) {
        $sql = "UPDATE Inventory SET stock_quantity = ?, updated_at = NOW() WHERE product_id = ?";
        return $this->db->update($sql, [$stockQuantity, $productId]);
    }

    public function getStockByProductId($productId) {
        $sql = "SELECT * FROM Inventory WHERE product_id = ?";
        return $this->db->select($sql, [$productId]);
    }

    public function getAllStocks() {
        $sql = "SELECT * FROM Inventory";
        return $this->db->select($sql);
    }
}
?>
