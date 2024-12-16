<?php
class Review extends Db{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addReview($productId, $userId, $rating, $comment) {
        $sql = "INSERT INTO reviews (product_id, user_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
        return $this->db->insert($sql, [$productId, $userId, $rating, $comment]);
    }

    public function getReviewsByProductId($productId) {
        $sql = "SELECT * FROM reviews WHERE product_id = ?";
        return $this->db->select($sql, [$productId]);
    }

    public function getAllReviews() {
        $sql = "SELECT * FROM reviews";
        return $this->db->select($sql);
    }
}
?>
