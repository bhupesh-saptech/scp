<?php
    namespace Contr;
    use Model\VehItem;
    class VehItemContr extends VehItem {

        public function __construct() {
            
        }
        public function createVehItem($rqst) {
            $this->setVehItem($rqst);

        }
        public function modifyVehItem($rqst) {
            $this->modVehItem($rqst);
        }
        public function deleteVehItem($rqst) {
            $this->delVehItem($rqst);
        }
    }