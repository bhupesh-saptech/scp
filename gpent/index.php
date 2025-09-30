<?php
    $_SESSION['pref_id'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;
    require '../incld/verify.php';
    require '../gpent/check_auth.php';
    require '../incld/autoload.php';
    $util = new Model\Util();
    $sess = json_decode(json_encode($_SESSION));
    if(isset($_GET['action'])) {
        $rqst = json_decode(json_encode($_GET));
        $_SESSION['supp_id'] = $rqst->supp_id;
        header('location: ../suppl/index.php');
        exit;
    }
    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../gpent/side_menu.php'; 
    require '../gpent/dashboard.php';    
    require '../gpent/tabl_dash.php';
?>