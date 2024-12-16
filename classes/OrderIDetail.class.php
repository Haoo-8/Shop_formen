<?php
    class OrderDetail extends Db{
        public function getAllOrderDetail(){
            $query = "SELECT * FROM order_items";
            return $this->select($query);
        }
        public function getOrderDetailByOrderId($orderId){
            $query = "SELECT * FROM order_items WHERE order_id = :orderId";
            $arrParam = array(':orderId' => $orderId);
            return $this->select($query, $arrParam);
        }
        
    }

?>