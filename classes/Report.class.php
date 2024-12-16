<?php

class Report extends Db
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // Lấy tổng doanh thu
    public function getTotalRevenue($startDate, $endDate)
    {
        $query = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE order_status = 'completed' AND order_date BETWEEN ? AND ?";
        return $this->db->select($query, [$startDate, $endDate])[0]['total_revenue'] ?? 0;
    }

    // Lấy tổng số đơn hàng
    public function getTotalOrders($startDate, $endDate)
    {
        $query = "SELECT COUNT(*) AS total_orders FROM orders WHERE order_status = 'completed' AND order_date BETWEEN ? AND ?";
        return $this->db->select($query, [$startDate, $endDate])[0]['total_orders'] ?? 0;
    }

    // Lấy tổng số sản phẩm đã bán
    public function getTotalProducts($startDate, $endDate)
    {
        $query = "
            SELECT SUM(quantity) AS total_products 
            FROM order_details od 
            JOIN orders o ON od.order_id = o.order_id 
            WHERE o.order_status = 'completed' AND o.order_date BETWEEN ? AND ?";
        return $this->db->select($query, [$startDate, $endDate])[0]['total_products'] ?? 0;
    }

    // Doanh thu từng tháng
    public function getMonthlyRevenue($startDate, $endDate)
    {
        $query = "
            SELECT MONTH(order_date) AS month, SUM(total_price) AS revenue  
            FROM orders 
            WHERE order_status = 'completed' AND order_date BETWEEN ? AND ?
            GROUP BY MONTH(order_date)";
        return $this->db->select($query, [$startDate, $endDate]);
    }

    public function getTopProducts($limit = 10) {
        $sql = "SELECT p.product_name, SUM(oi.quantity) as total_quantity, SUM(oi.price * oi.quantity) as total_revenue
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                GROUP BY oi.product_id
                ORDER BY total_quantity DESC
                LIMIT ?";
        return $this->db->select($sql, [$limit]);
    }

    public function getRevenueByCategory($limit = 10) {
        $sql = "SELECT c.category_name, SUM(oi.price * oi.quantity) as total_revenue
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                JOIN categories c ON p.category_id = c.category_id
                GROUP BY c.category_id
                ORDER BY total_revenue DESC
                LIMIT ?";
        return $this->db->select($sql, [$limit]);
    }
}
