<?php
    session_start();
    if(isset($_SERVER['CONTENT_TYPE'])) {
        $ctype = $_SERVER['CONTENT_TYPE'];
    } else {
        $ctype = 'text/html';
    }
    if($ctype == 'application/json') {
        header('Content-Type: application/json');
    } else {
        header('Content-Type: text/html');
    }
    if(isset($_SERVER['REQUEST_METHOD'])) {
        $mthd = $_SERVER['REQUEST_METHOD'];
    } else {
        $mthd = "GET";
    }
    $rqst = json_decode(file_get_contents('php://input'));
    if($rqst instanceof stdClass) {
        if(!property_exists($rqst,'submit')) {
            $rqst->submit = '';
        }
    } else {
        $rqst = json_decode(json_encode($_REQUEST));
        if(!property_exists($rqst,'submit')) {
            $rqst->submit = '';
        }
    }
    switch($mthd) {
        case "GET":
            include('../incld/dbconn.php');
            $dtset = $conn->query("select *
                                     from veh_data
                                    where pass_id='$rqst->pass_id'");
            $item  = $dtset->fetch_assoc();
            $dtset = $conn->query("select * 
                                     from veh_item 
                                    where pass_id='$rqst->pass_id'");
            $items = $dtset->fetch_all(MYSQLI_ASSOC);
            $data = json_encode(array(  "zpass"=>$item,
                                        "items"=>$items));
            $conn->close();
            if($ctype == 'application/json') {
                echo $data;    
                die();
            }
            break;
        case "POST":
            switch($rqst->submit) {
                case 'ckiVeh' : 
                    include('../incld/dbconn.php');
                    $dtset = $conn->query("update veh_pass set cstat = 'CI' where pass_id='$rqst->pass_id'");
                    $_SESSION['status'] = "Vehicle Checked IN";
                    $conn->close(); 
                    break;
                case 'recVeh' : 
                    include('../incld/dbconn.php');
                    $dtset = $conn->query("update veh_pass set cstat = 'VA' where pass_id='$rqst->pass_id'");
                    $_SESSION['status'] = "Vehicle Recorded";
                    $conn->close(); 
                    break;
            }
            if(isset($_SESSION['pref_id'])) {
                $page_id = $_SESSION['pref_id'];
                header("location:".$page_id);
            }
            break;
    }
    include('../incld/verify.php');
    include('../waybr/check_auth.php');
    include('../incld/header.php');
    include('../incld/dbconn.php');
    $dtset = $conn->query("select * 
                             from veh_data
                            where pass_id='$rqst->pass_id'");
    $item  = json_decode(json_encode($dtset->fetch_assoc()));
    $conn->close();
    
?>        
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- left column -->
            </div>
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Vehicle Gate Pass Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include('../incld/messages.php'); ?>
                            <form method="POST"  >
                                <div class="modal-footer">
                                    <?php if($item->cstat == 'VP') { ?>
                                        <button type="submit" name="submit" class="btn btn-primary" value="recVeh" <?php if($item->cstat != 'VP' ) { echo 'disabled';} ?>>Receive Vehicle</button>
                                    <?php } else { ?>
                                        <button type="submit" name="submit" class="btn btn-primary" value="ckiVeh" <?php if( $item->cstat != 'QA') { echo 'disabled';} ?>>Vehicle Check IN</button>
                                    <?php 
                                          }
                                    ?>
                                    </div>
                                <div class="form-group">
                                    <label for="">Vehicle No</label>
                                    <input type="text" name="zvehn"   class="form-control bg-primary" value="<?php echo $item->zvehn; ?>"   readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Vehicle Pass</label>
                                    <input type="text" name="pass_id" class="form-control" value="<?php echo $item->pass_id; ?>" readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Vehicle Status</label>
                                    <input type="text" name="zcstat" class="form-control" value="<?php  echo $item->sdesc; ?>" readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Gate Pass</label>
                                    <input type="text" name="zvpno" class="form-control"   value="<?php echo $item->zvpno; ?>"    readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Usage Decision</label>
                                    <input type="text" name="zzins" class="form-control <?php echo $item->vccol; ?>" value="<?php  echo $item->idesc; ?>" readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Transporter</label>
                                    <input type="text" name="ztnam"   class="form-control" value="<?php echo $item->ztnam; ?>"   readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Driver Name</label>
                                    <input type="text" name="zdnam" class="form-control" value="<?php echo $item->zdnam;?>"    readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Driver Phone</label>
                                    <input type="text" name="zmbno"   class="form-control" value="<?php echo $item->zmbno; ?>"   readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Shipment</label>
                                    <input type="text" name="tknum" class="form-control"   value="<?php echo $item->tknum; ?>"    readonly >
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include('../incld/jslib.php');
    include('../incld/footer.php');
?>
