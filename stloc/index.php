<?php
    $_SESSION['pref_id'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    require '../incld/verify.php';
    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../stloc/side_menu.php'; 
    require '../stloc/dashboard.php';
    require '../commn/tabl_dash.php';    
?>