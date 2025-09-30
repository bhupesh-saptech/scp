<?php
    require '../incld/verify.php';
    require '../buyer/check_auth.php';
    require '../incld/header.php';
    require '../buyer/top_menu.php';
    require '../buyer/side_menu.php';
    require '../buyer/dashboard.php';
    require '../incld/autoload.php';
    $conn = new Model\Conn();
    $query = "select * from pur_grps where user_id = ?";
    $param = array($_SESSION['user_id']);
    $items = $conn->execQuery($query,$param);
    $query = "select * from usr_data where role_nm = ?";
    $param = array('buyer');
    $users = $conn->execQuery($query,$param);
?>


<div class="card">
    <div class="card-header">
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Group</th> 
                    <th>Group Name</th>
                    <th>Email ID</th>
                    <th>Contact</th>
                    <th>Mobile No</th>
                    <th>Extension</th>
                </tr>
            </thead>
            <?php 
                foreach($items as $item) { 
            ?>
            <tr>
                <td><?php echo $item->ekgrp; ?> <input type="hidden" name="pgrp_id" value="<?php echo $item->pgrp_id ;?>"></td>
                <td><?php echo $item->eknam; ?> </td>
                <td><?php echo $item->email; ?> </td>
                <td><?php echo $item->ektel; ?> </td>
                <td><?php echo $item->phone; ?> </td>
                <td><?php echo $item->extno; ?> </td>
            </tr>
            <?php 
                    } 
            ?>
        </table>
    </div>
</div>

<?php
    require '../incld/jslib.php';
    require '../incld/footer.php';
?>