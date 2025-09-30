<?php 
    if(isset($_SESSION['role_id'])) {
        $role_id = $_SESSION['role_id'];
        if ($role_id != '4') {
            echo "<h1 style='text-align: center;;color:red;'>you are not authorized to access this page</h1>";
            die();
        }
    }
?>