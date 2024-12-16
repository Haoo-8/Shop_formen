<?php
class Category extends Db{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCategory($name, $description) {
        $sql = "INSERT INTO categories (category_name, description) VALUES (?, ?)";
        return $this->db->insert($sql, [$name, $description]);
    }

    public function updateCategory($categoryId, $name, $description) {
        $sql = "UPDATE categories SET category_name = ?, description = ? WHERE category_id = ?";
        return $this->db->update($sql, [$name, $description, $categoryId]);
    }

    public function deleteCategory($categoryId) {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $this->db->delete($sql, [$categoryId]);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    

    public function getAllCategories() {
        $sql = "SELECT * FROM categories";
        return $this->db->select($sql);
    }
    public function getCategoryCount() {
        $sql = "SELECT COUNT(*) AS count FROM categories";
        $result = $this->db->select($sql);
        return $result[0]['count'] ?? 0;
    }
    
}
?>
