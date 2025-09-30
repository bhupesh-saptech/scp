<?php
    namespace Model;
    use Model\Conn;
    class POItem extends Conn {
        protected function getPOItem($query,$param =[]) {
            $stmt = $this->connect()->prepare($query);
            $rset = $stmt->execute($param);
            return $stmt->fetchAll();  
        }
    }
