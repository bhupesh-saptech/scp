<?php
    $incl = "incld";
    $comm = "commn";
    require "../{$incl}/verify.php";
    $role = $_SESSION['role_nm'];
    require "../{$role}/check_auth.php";
    require "../{$incl}/header.php";
    require "../{$incl}/top_menu.php";
    require "../{$role}/side_menu.php";
    require "../{$role}/dashboard.php";
    require "../{$incl}/autoload.php";
    require "../{$comm}/tabl_pass.php";
?>