<?php
class Product extends Db
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getRand($n)
    {
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT $n";
        return $this->db->select($query);
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        return $this->db->select($query);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE product_id = :id";
        $arrParam = array(':id' => $id);
        return $this->db->select($query, $arrParam);
    }

    public function addProduct($data)
    {
        $query = "INSERT INTO products (name, description, price) VALUES (:name, :description, :price)";
        $arrParam = array(
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price']
        );

        if ($this->db->insert($query, $arrParam)) {
            return $this->db->getLastInsertId(); // Lấy ID vừa chèn
        }
        return false;
    }

    public function addProducts($name, $description, $price)
    { // Assuming $this->db is your database connection 
        $query = "INSERT INTO products (name, description, price) VALUES (:name, :description, :price)";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':price', $price);
        try {
            $statement->execute();
            echo "Product added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateProduct($data)
    {
        $query = "UPDATE products SET name = :name, description = :description, price = :price WHERE product_id = :id";
        $arrParam = array(':name' => $data['name'], ':description' => $data['description'], ':price' => $data['price'], ':id' => $data['id']);
        return $this->db->update($query, $arrParam);
    }

    public function updateProducts($id, $name, $description, $price)
    {
        $query = "UPDATE products SET name = :name, description = :description, price = :price WHERE product_id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':id', $id);
        try {
            $statement->execute();
            echo "Product updated successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE product_id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $id);
        try {
            $statement->execute();
            echo "Product deleted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function searchProduct($keyword)
    {
        $query = "SELECT * FROM products WHERE name LIKE :keyword OR description LIKE :keyword";
        $arrParam = array(':keyword' => '%' . $keyword . '%');
        return $this->db->selectAll($query, $arrParam);
    }
    public function getProductDetail($id)
    {
        $query = "
        SELECT 
        p.name, 
        p.price, 
        p.image_url, 
        GROUP_CONCAT(DISTINCT c.color_name) AS color_names, 
        GROUP_CONCAT(DISTINCT c.color_code) AS color_codes, 
        GROUP_CONCAT(DISTINCT s.size_name) AS sizes
        FROM products p
        JOIN productvariants pv ON p.product_id = pv.product_id
        LEFT JOIN colors c ON pv.color_id = c.color_id
        LEFT JOIN sizes s ON pv.size_id = s.size_id
        WHERE p.product_id = :product_id
        GROUP BY p.product_id";
        $arrParam = array(':product_id' => $id);
        $result = $this->db->select($query, $arrParam);
        if ($result) {
            $product = $result[0];
            $product['colors'] = [];
            if (isset($product['color_names']) && isset($product['color_codes'])) {
                $colorNames = explode(',', $product['color_names']);
                $colorCodes = explode(',', $product['color_codes']);
                foreach ($colorNames as $index => $name) {
                    $product['colors'][] = [
                        'color_name' => $name,
                        'color_code' => $colorCodes[$index] ?? ''
                    ];
                }
            }
            $product['sizes'] = isset($product['sizes']) ? explode(',', $product['sizes']) : [];
            return $product;
        }
    }

    public function getTopSellingProducts($limit = 5)
    {
        $query = "SELECT * FROM products ORDER BY sold_quantity DESC LIMIT :limit";
        $arrParam = array(':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }

    public function getProductsByCategory($categoryId) {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        return $this->db->fetchAll($sql, [$categoryId]);
    }
    public function getProductById2($id) {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }



    public function getProductsByPriceRange($minPrice, $maxPrice, $limit = 10)
    {
        $query = "SELECT * FROM products WHERE price BETWEEN :minPrice AND :maxPrice LIMIT :limit";
        $arrParam = array(':minPrice' => $minPrice, ':maxPrice' => $maxPrice, ':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }

    public function getRelatedProducts($productId, $limit = 5)
    {
        $query = "SELECT * FROM products WHERE category_id = (SELECT category_id FROM products WHERE product_id = :productId) AND product_id!= :productId LIMIT :limit";
        $arrParam = array(':productId' => $productId, ':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }

    // public function getProductsByTag($tagId, $limit = 10){
    //     $query = "SELECT * FROM products WHERE tag_id = :tagId LIMIT :limit";
    //     $arrParam = array(':tagId' => $tagId, ':limit' => $limit);
    //     return $this->db->select($query, $arrParam);
    // }

    public function getProductsByFilter($filters, $limit = 10)
    {
        $query = "SELECT * FROM products WHERE 1";
        $arrParam = array();
        foreach ($filters as $key => $value) {
            $query .= " AND $key = :$key";
            $arrParam[":$key"] = $value;
        }
        $query .= " LIMIT :limit";
        $arrParam[":limit"] = $limit;
        return $this->db->select($query, $arrParam);
    }

    // Hàm lấy kích thước của sản phẩm 
    public function getSizesForProduct($productId)
    {
        $sql = "SELECT DISTINCT s.size_name FROM productvariants pv 
        JOIN sizes s ON pv.size_id = s.size_id 
        JOIN products p ON pv.product_id = p.product_id
        WHERE p.product_id = :product_id";
        $sizes = $this->db->selectAll($sql, ['product_id' => $productId]);
        return $sizes;
    }
    // Hàm lấy màu sắc của sản phẩm 
    public function getColorsForProduct($productId)
    {
        $sql = "SELECT DISTINCT c.color_name FROM productvariants pv 
                JOIN colors c ON pv.color_id = c.color_id 
                JOIN products p ON pv.product_id = p.product_id
                WHERE p.product_id =:product_id";
        $colors = $this->db->selectAll($sql, ['product_id' => $productId]);
        return $colors;
    }
    // Hàm lấy mã giảm giá của sản phẩm 
    // public function getCouponForProduct($productId)
    // {
    //     $sql = "SELECT c.code, c.discount_value 
    //     FROM coupons c
    //     JOIN products p ON p.coupon_id = c.id
    //     WHERE p.product_id = :product_id AND c.expiry_date >= CURDATE()";
    //     $coupon = $this->db->selectAll($sql, ['product_id' => $productId]);
    //     return $coupon;
    // }

    public function getProductsByColor($colorId, $limit = 10)
    {
        $query = "SELECT p.* FROM products p 
                  JOIN productvariants pv ON p.product_id = pv.product_id 
                  WHERE pv.color_id = :colorId LIMIT :limit";
        $arrParam = array(':colorId' => $colorId, ':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }

    public function getProductsBySize($sizeId, $limit = 10)
    {
        $query = "SELECT p.* FROM products p 
                  JOIN productvariants pv ON p.product_id = pv.product_id 
                  WHERE pv.size_id = :sizeId LIMIT :limit";
        $arrParam = array(':sizeId' => $sizeId, ':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }



    // public function getProductsByMaterial($materialId, $limit = 10){
    //     $query = "SELECT * FROM products WHERE material_id = :materialId LIMIT :limit";
    //     $arrParam = array(':materialId' => $materialId, ':limit' => $limit);
    //     return $this->db->select($query, $arrParam);
    // }
    // Tuoi, Chat lieu, Thuong Hieu


    public function getProductsByDate($date, $limit = 10)
    {
        $query = "SELECT * FROM products WHERE created_at LIKE :date LIMIT :limit";
        $arrParam = array(':date' => $date . '%', ':limit' => $limit);
        return $this->db->select($query, $arrParam);
    }
    public function getAllProductsByCategory($categoryId)
    {
        $sql = "SELECT * FROM products WHERE category_id = :category_id";
        return $this->db->select($sql, [":category_id" => $categoryId]);
    }

    public function getProductCount() {
        $sql = "SELECT COUNT(*) AS count FROM products";
        $result = $this->db->select($sql);
        return $result[0]['count'] ?? 0;
    }
    
}
