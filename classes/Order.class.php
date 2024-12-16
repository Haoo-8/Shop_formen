<?php
class Order extends Db
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getAllOrders() {
        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        return $this->db->select($sql);
    }
    public function getOrderDetails($orderId) {
        $sql = "SELECT * FROM order_details WHERE order_id = ?";
        return $this->db->select($sql, [$orderId]);
    }

    public function createOrder($userId, $totalAmount, $status = 'Pending')
    {
        $sql = "INSERT INTO orders (user_id, order_date, status, total_amount) VALUES (?, NOW(), ?, ?)";
        return $this->db->insert($sql, [$userId, $status, $totalAmount]);
    }
    public function createCart($userId, $products) {
        $sql = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
        $orderId = $this->db->insert($sql, [$userId]);

        if ($orderId) {
            foreach ($products as $productId => $quantity) {
                $sqlDetail = "INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)";
                $this->db->insert($sqlDetail, [$orderId, $productId, $quantity]);
            }
            return true;
        }
        return false;
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        return $this->db->update($sql, [$status, $orderId]);
    }

    public function deleteOrder($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        return $this->db->delete($sql, [$orderId]);
    }
     
}

?>
