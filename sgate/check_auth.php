<?php 
    if(isset($_COOKIE['role_id'])) {
        $role_id = $_COOKIE['role_id'];
        if ($role_id == '0') {
            echo "<h1 style='text-align: center;;color:red;'>you are not authorized to access this page</h1>";
            die();
        }
    }
?>