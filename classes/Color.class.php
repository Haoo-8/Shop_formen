<?php
    class Color extends Db{
        private $db;
        public function __construct($db){
            $this->db = $db;
        }
        public function getAllColors(){
            $query = "SELECT * FROM colors";
            return $this->db->select($query);
        }
        public function getColorById($id){
            $query = "SELECT * FROM colors WHERE color_id = :id";
            $arrParam = array(':id' => $id);
            return $this->db->select($query, $arrParam);
        }

    }
?>