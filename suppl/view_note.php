<?php
    include('../incld/verify.php');
    include('../suppl/check_auth.php');
    include('../incld/dbconn.php');
    $item = new stdClass();
    if(isset($_POST['action'])) {
        if(isset($_POST['pass_id'])) {
            $post = json_decode(json_encode($_POST));
            $dset = $conn->query("select * from despnote where pass_id='$post->pass_id'");
            $item = json_decode(json_encode($dset->fetch_assoc()));
            $item->action = $post->action;
        } else {
            $item->pass_id = '';
            $item->signi   = '';
            $item->text1   = '';
            $item->exti1   = '';
            $item->exti2   = '';
            $item->tpbez   = '';
            $item->lifnr   = $_SESSION['supp_id'];
            $item->tknum   = '';
        }
    } else {
        $item->action  = 'add';
        $item->pass_id = '';
        $item->signi   = '';
        $item->text1   = '';
        $item->exti1   = '';
        $item->exti2   = '';
        $item->tpbez   = '';
        $item->lifnr   = $_SESSION['supp_id'];
        $item->tknum   = '';
    }
    switch($item->action) {
        case 'add'   : 
            $item->btn_txt = 'Create Pass';
            break;
        case 'view'  :
            $item->btn_txt = 'Close';
        //    $item->btn_txt = 'Close';
            break;
        case 'edit'  :
            $item->btn_txt = 'Update Pass';
            break;
        case 'delete':
            $item->btn_txt = 'Delete Pass';
            break;
    }
    if( isset($_POST['crudat'])) {
        $item   = json_decode(json_encode($_POST));
        $action = $item->crudat;
        switch($action) {
            case 'add'   : 
                $item->pass_id = $scnt['pass_id'] + 1;
                $sqls = "insert into gatepass (pass_id,
                                               signi,
                                               text1,
                                               exti1,
                                               exti2,
                                               tpbez,
                                               lifnr)
                                values (    '$item->pass_id,
                                            '$item->signi',
                                            '$item->text1',
                                            '$item->exti1',
                                            '$item->exti2',
                                            '$item->tpbez',
                                            '$item->lifnr')";
                if($conn->query($sqls)) {
                    $_SESSION['status'] = 'User added successfully';
                } else {
                    $_SESSION['status'] = 'User registration failed';
                }
                break;
            case 'view'  :
                break;
            case 'edit'  :
                $sqls = "update gatepass  set   signi   = '$item->signi',
                                                text1   = '$item->text1',
                                                exti1   = '$item->exti1',
                                                exti2   = '$item->exti2',
                                                tpbez   = '$item->tpbez',
                                                lifnr   = '$item->lifnr'
                                        where   pass_id = '$item->pass_id'";
                if($conn->query($sqls)) {
                    $_SESSION['status'] = 'User updated successfully';
                } else {
                    $_SESSION['status'] = 'User updation failed';
                }
                
                break;
            case 'delete':
                $sqls = "delete from gatepass where pass_id = '$item->pass_id'";
                if($conn->query($sqls)) {
                    $_SESSION['status'] = 'User Deleted successfully';
                } else {
                    $_SESSION['status'] = 'User Deletion failed';
                }
                break;
            }
        $conn->close();
        header("Location:list_pass.php");
        exit(0);
    }
    include('../incld/header.php');
    include('../incld/top_menu.php');
    include('../admin/side_menu.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Vehicle Gate Pass Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Pass</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehicle Pass</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST"  >
                        <div class="form-group">
                            <label for="">Pass ID</label>
                            <input type="text" name="pass_id" class="form-control" placeholder="Pass ID" value="<?php echo $item->pass_id; ?>" required readonly >
                        </div>
                        <div class="form-group">
                            <label for="">Vehicle No</label>
                            <input type="text" name="signi" class="form-control" placeholder="Vehicle No" value="<?php echo $item->signi; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Transporter</label>
                            <input type="text" name="text1" class="form-control" placeholder="Transporter Name" value="<?php echo $item->text1;?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Driver Name</label>
                            <input type="text" name="exti1" class="form-control" placeholder="Driver Name" value="<?php echo $item->exti1;?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Driver Phone</label>
                            <input type="text" name="exti2" class="form-control" placeholder="Phone" value="<?php echo $item->exti2; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Driver License</label>
                            <input type="text" name="tpbez" class="form-control" placeholder="License" value="<?php echo $item->tpbez; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <input type="text" name="lifnr" class="form-control" placeholder="Supplier" value="<?php echo $item->lifnr; ?>">
                        </div>
                        <div class="modal-footer">
                            <a name="a_back" class="btn btn-secondary" href="list_pass.php">Back</a>
                            <button type="submit" name="crudat" class="btn btn-secondary" value="<?php echo $item->action;?>"><?php echo $item->btn_txt;?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include('../incld/footer.php');
?>