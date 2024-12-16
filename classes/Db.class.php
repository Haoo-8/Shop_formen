<?php
require_once ROOT . '/config/config.php';

class Db
{
    private $_numRow;
    private $dbh = null;

    public function __construct()
    {
        $driver = "mysql:host=" . HOST . "; dbname=" . DB_NAME;
        try {
            $this->dbh = new PDO($driver, DB_USER, DB_PASS);
            $this->dbh->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Err:" . $e->getMessage();
            exit();
        }
    }

    public function ___destruct()
    {
        $this->dbh = null;
    }

    public function execute($sql, $params = []){
        try {
            $stm = $this->dbh->prepare($sql);
            $stm->execute($params);
            return $stm->rowCount();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function prepare($query){
        return $this->dbh->prepare($query);
    }


    public function selectOne($sql, $params = [])
    {
        try {
            $stm = $this->dbh->prepare($sql);
            $stm->execute($params);
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function selectAll($sql, $params = [])
    {
        $stm = $this->dbh->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRowCount()
    {
        return $this->_numRow;
    }

    public function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $stm = $this->dbh->prepare($sql);
        if (!$stm->execute($arr)) {
            echo "Sql Error!";
            exit;
        }
        $this->_numRow = $stm->rowCount();
        return $stm->fetchAll($mode);
    }

    public function select($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        return $this->query($sql, $arr, $mode);
    }

    public function insert($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    public function update($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    public function delete($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
    {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function fetchAll($sql, $params = []) {
        try {
            $stmt = $this->dbh->prepare($sql); // Chuẩn bị truy vấn
            foreach ($params as $key => $value) {
                $stmt->bindValue($key + 1, $value); // Gán giá trị tham số
            }
            $stmt->execute(); // Thực thi truy vấn
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về kết quả dạng mảng kết hợp
        } catch (PDOException $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }
    }
    public function fetchRow($sql, $params = []) {
        try {
            $stmt = $this->dbh->prepare($sql); // Chuẩn bị truy vấn
            foreach ($params as $key => $value) {
                $stmt->bindValue($key + 1, $value); // Gán giá trị tham số
            }
            $stmt->execute(); // Thực thi truy vấn
            return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về một dòng kết quả
        } catch (PDOException $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }
    }
    
    
}
