<?php
class Cart
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($userId, $productId, $quantity)
    {
        $existing = $this->db->select("SELECT * FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);
        if ($existing) {
            $this->db->update("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?", [$quantity, $userId, $productId]);
        } else {
            $this->db->insert("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)", [$userId, $productId, $quantity]);
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCart($userId)
    {
        return $this->db->select("SELECT c.*, p.name, p.price, p.image_url 
                                  FROM cart c 
                                  JOIN products p ON c.product_id = p.product_id 
                                  WHERE c.user_id = ?", [$userId]);
    }
}
?>