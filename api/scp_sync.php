<?php
    
    include('../incld/autoload.php');

    header("Content-Type: application/json");

    $mthd = $_SERVER['REQUEST_METHOD'];
    
    
    $util = new Model\Util();

    switch ($mthd) {
        case 'GET':
            $rqst = json_decode(json_encode($_GET));
            $query = "select * from obj_type where objty = ?";
            $param = array($rqst->objty);
            $objty = $util->execQuery($query,$param,1);
            $query = "select * from {$objty->table} where objky = ?";
            $param = array($rqst->objky);
            $items  = $util->execQuery($query,$param);
            $resp = new stdClass();
            $resp->methd = "readData";
            $resp->objty = "{$rqst->objty}";
            $resp->items = $items;
            echo json_encode($resp);
            die();
            break;  
        case 'POST':
            $rqst = json_decode(file_get_contents('php://input'));
            $cntr = new Contr\SAPContr();
            call_user_func_array([$cntr, $rqst->methd], array($rqst));
            switch($rqst->objty) {
                case 'PSGP' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'PIBD' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'P103' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'PTKN' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'PGWT' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'PTWT' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'P105' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                case 'PSHC' :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->vpass->zpsid} Updated"]);
                    break;
                default     :
                    echo json_encode(["message" => "{$rqst->objty} : {$rqst->items[0]->objky} created"]);
                    break;
            }
            die();
            break;
    } 
    

?>