<?php
    class Size extends Db{
        private $db;
        public function __construct($db){
            $this->db = $db;
        }
        public function getAllSizes(){
            $query = "SELECT * FROM sizes";
            return $this->db->select($query);
        }

    }
?>