<?php
$_SESSION['origion'] = 'qrcd';
    if(isset($_GET['pass_id'])) {
        $pass_id = $_GET['pass_id'];
    }  
    if(isset($_SESSION['role_nm'])) {
        switch($_SESSION['role_nm']) {
            case "suppl" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$pass_id}";
            case "admin" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$pass_id}";
            case "buyer" :
                $pass_page = "../suppl/disp_pass.php?pass_id={$pass_id}";
            case "stloc" :
                $pass_page = "../stloc/disp_pass.php?pass_id={$pass_id}";
            case "qinsp" :
                $pass_page = "../qinsp/disp_pass.php?pass_id={$pass_id}";
            case "sgate" :
                $pass_page = "../sgate/disp_pass.php?pass_id={$pass_id}";
            default : 
                $pass_page = "../suppl/disp_pass.php?pass_id={$pass_id}";
        }
    } else {
        $pass_page = "../suppl/disp_pass.php?pass_id={$pass_id}";
    }  
    header("location:".$pass_page);
?>
   