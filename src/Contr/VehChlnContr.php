<?php
    namespace Contr;
    use Model\VehChln;
    class VehChlnContr extends VehChln {
        public function __construct() {
            
        }
        public function createVehChln($rqst) {
            $this->setVehChln($rqst);

        }
        public function modifyVehChln($rqst) {
            $this->modVehChln($rqst);
        }
        public function deleteVehChln($rqst) {
            $this->delVehChln($rqst);
        }

    }
?>