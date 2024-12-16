<?php
class Coupon extends Db
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function applyCoupon($code, $productId)
    {
        $sql = "SELECT * FROM coupons WHERE code = ? AND product_id = ? AND expiry_date >= CURDATE()";
        $coupon = $this->db->selectOne($sql, [$code, $productId]);
        if ($coupon) {
            return $coupon['discount_value'];
        } else {
            return false;
        }
    }
    public function addCoupon($code, $discountPercentage, $startDate, $endDate)
    {
        $sql = "INSERT INTO coupons(code, discount_percentage, start_date, end_date) VALUES(?,?,?,?)";
        return $this->db->insert($sql, [$code, $discountPercentage, $startDate, $endDate]);
    }
    public function getAllCoupons()
    {
        $sql = "SELECT * FROM coupons";
        return $this->db->select($sql);
    }
    public function getCouponByCode($code)
    {
        $sql = "SELECT * FROM coupons WHERE code =?";
        return $this->db->select($sql, [$code]);
    }
    public function updateCoupon($couponId, $code, $discountPercentage, $startDate, $endDate)
    {
        $sql = "UPDATE coupons SET code=?, discount_percentage=?, start_date=?, end_date=? WHERE coupon_id=?";
        return $this->db->update($sql, [$code, $discountPercentage, $startDate, $endDate, $couponId]);
    }
    public function deleteCoupon($couponId)
    {
        $sql = "DELETE FROM coupons WHERE coupon_id=?";
        return $this->db->delete($sql, [$couponId]);
    }
}
