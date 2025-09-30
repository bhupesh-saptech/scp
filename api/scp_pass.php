<?php
    session_start();
    require '../incld/autoload.php';
    $conn  = new Model\Conn();
    $_SESSION['origion'] = 'qrcd';
    $ctyp = $_SERVER["CONTENT_TYPE"] ?? $_SERVER["HTTP_CONTENT_TYPE"] ?? "Not Set";
    $rqst = json_decode(json_encode($_GET));
    if($ctyp == 'application/json') {
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
    }
    $query = "select * from veh_pass where pass_id = ?";
    $param = array($rqst->pass_id);
    $pass  = $conn->execQuery($query,$param,1); 
    $sess = json_decode(json_encode($_SESSION));
    if(isset($sess->role_nm)) {
        switch($sess->role_nm) {
            case "suppl" :
                $pass_page = "../api/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "admin" :
                $pass_page = "../api/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "buyer" :
                $pass_page = "../api/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            case "stloc" :
                $pass_page = "../stloc/list_chln.php?pass_id={$rqst->pass_id}";
                break;
            case "qinsp" :
                if ($pass->cstat == 'VA') {
                    $pass_page = "../qinsp/disp_pass.php?pass_id={$rqst->pass_id}";
                } else {
                    $pass_page = "../qinsp/list_chln.php?pass_id={$rqst->pass_id}";
                }
                break;
            case "sgate" :
                $pass_page = "../sgate/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
            default : 
                $pass_page = "../api/disp_pass.php?pass_id={$rqst->pass_id}";
                break;
        }
    } else {
        $pass_page = "../api/disp_pass.php?pass_id={$rqst->pass_id}";
    }  
    header("location:".$pass_page);
?>