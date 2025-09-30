<?php
    namespace Contr;
    use Model\POItem;
    class POItemContr extends POItem {
        private $list;

        public function __construct() {
        }
        public function readPOItem($query,$param=[]) {
            $this->list = $this->getPOItem($query,$param);
            return $this->list;
        }
    }