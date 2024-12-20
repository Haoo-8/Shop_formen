<?php
class Order extends Db
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllOrders()
    {
        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        return $this->db->select($sql);
    }
    public function getOrderDetails($orderId)
    {
        $sql = "SELECT * FROM order_details WHERE order_id = ?";
        return $this->db->select($sql, [$orderId]);
    }

    public function createOrder($customerId, $customerName, $customerEmail, $customerPhone, $shippingAddress, $totalPrice, $paymentMethod)
    {
        $sql = "INSERT INTO orders (customer_id, customer_name, customer_email, customer_phone, total_price, payment_method, shipping_address, order_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $customerId,
            $customerName,
            $customerEmail,
            $customerPhone,
            $totalPrice,
            $paymentMethod,
            $shippingAddress
        ]);
    }


    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        return $this->db->update($sql, [$status, $orderId]);
    }

    public function deleteOrder($orderId)
    {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        return $this->db->delete($sql, [$orderId]);
    }

}
