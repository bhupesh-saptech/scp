<?php
    require '../incld/verify.php';
    require '../admin/check_auth.php';
    require '../incld/header.php';
    require '../admin/top_menu.php';
    require '../admin/side_menu.php';
    require '../admin/dashboard.php';
    require '../incld/autoload.php';
    $conn = new Model\Conn();
    $query = "select * from usr_role";
    $param = array();
    $items = $conn->execQuery($query,$param);
    

?>
<div class="card">
    <div class="card-header">
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Role_ID</th> 
                    <th>Role No</th>
                    <th>Home Page</th>
                    <th>Role Name</th>
                    <th>Users</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php 
                foreach($items as $item) { 
                    $query = "select count(*) as count from users where role_id = ?";
                    $param = array($item->role_id);
                    $users = $conn->execQuery($query,$param,1);
                    $users->count = str_pad($users->count, 5, '0', STR_PAD_LEFT);
            ?>
            <tr>
                <td><?php echo $item->role_id; ?> <input type="hidden" name="role_id" value="<?php echo $item->role_id ;?>"></td>
                <td><?php echo $item->role_nm; ?> </td>
                <td><?php echo $item->home_pg; ?> </td>
                <td><?php echo $item->role_ds; ?> </td>
                <td class="text-center"><a href="list_users.php?role_nm=<?php echo $item->role_nm;?>"><?php echo "{$users->count}"; ?></a></td>
                <td class="text-center"><a href="disp_user.php?role_nm=<?php echo $item->role_nm;?>" class="btn btn-primary">Add User</a></td>
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