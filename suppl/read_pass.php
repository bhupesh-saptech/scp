<?php
    session_start();
    require '../incld/autoload.php';
    $_SESSION['origion'] = 'qrcd';
    $ctyp = $_SERVER["CONTENT_TYPE"] ?? $_SERVER["HTTP_CONTENT_TYPE"] ?? "Not Set";
    $mthd = $_SERVER["REQUEST_METHOD"];
    if($ctyp == 'application/json') {
        switch($mthd) {
            case 'GET' :
                $rqst = json_decode(json_encode($_GET));
                $conn  = new Model\Conn();
                $param = array($rqst->pass_id);
                $query = "select * from veh_pass where pass_id = ?";
                $pass  = $conn->execQuery($query,$param,1); 
                $query = "select * from veh_chln where pass_id = ?";
                $chlns  = $conn->execQuery($query,$param);
                $query = "select * from veh_item where pass_id = ?";
                $items  = $conn->execQuery($query,$param);
                $data = new stdClass();
                $data->vpass = $pass;
                $data->chlns = $chlns;
                foreach($chlns as $index => $chln) {
                    $query = "select * from veh_item where pass_id = ? and chln_id = ?";
                    $param = array($chln->pass_id,$chln->chln_id);
                    $items  = $conn->execQuery($query,$param);
                    $data->chlns[$index]->items = $items;
                }
                $resp = json_encode($data);
                echo $resp;
                die();
                break;
            case 'POST':
                $rqst = json_decode(file_get_contents('php://input'));
                switch($rqst->action) {
                    case 'updtPass' :
                        $conn = new Model\Conn();
                        $query = "update veh_pass set   zvpno   = :zvpno,
                                                        tknum   = :tknum
                                                  where pass_id = :pass_id";
                        $param = array($rqst->zvpno,$rqst->tknum,$rqst->pass_id);
                        $resp  = $conn->execQuery($query,$param);
                        echo json_encode(["message" => "Vehicle Pass updated successfully"]);
                        die();
                        break;
                    case 'updtItem' :
                        $conn = new Model\Conn();
                        $query = "update veh_item set vgbel   = :vgbel,
                                                      vgpos   = :vgpos,
                                                      md103   = :md103,
                                                      my103   = :my103,
                                                      mi103   = :mi103
                                                where pass_id = :pass_id
                                                  and chln_id = :chln_id
                                                  and item_id = :item_id";
                        $param = array(':vgbel'   =>$rqst->vgbel,
                                       ':vgpos'   =>$rqst->vgpos,
                                       ':md103'   =>$rqst->md103,
                                       ':my103'   =>$rqst->my103,
                                       ':mi103'   =>$rqst->mi103,
                                       ':pass_id' =>$rqst->pass_id,
                                       ':chln_id' =>$rqst->chln_id,
                                       ':item_id' =>$rqst->item_id);
                        $resp  = $conn->execQuery($query,$param);
                        echo json_encode(["message" => "Vehicle Pass updated successfully"]);
                        die();
                        break;
            }
                break;
                
        }
    }
    $rqst = json_decode(json_encode($_GET));
    if(isset($_SESSION['role_nm'])) {
        switch($_SESSION['role_nm']) {
            case "suppl" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "admin" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "buyer" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "stloc" :
                $pass_page = "../stloc/list_chln.php?pass_id={$rqst->pass_id}";
                break;
            case "qinsp" :
                $pass_page = "../qinsp/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "sgate" :
                $pass_page = "../sgate/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            default : 
                $pass_page = "../suppl/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
        }
    } else {
        $pass_page = "../suppl/disp_pass.php?pass_id={$rqst->pass_id}";
    }  
    header("location:".$pass_page);
?>