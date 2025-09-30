<?php 
    if(isset($_SESSION['role_no'])) {
        if ($_SESSION['role_no'] == 'suppl') {
            echo "<h1 style='text-align: center;;color:red;'>you are not authorized to access this page</h1>";
            die();
        }
    }
?>