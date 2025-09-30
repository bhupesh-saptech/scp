<?php
    include('../incld/verify.php');
    include('../sgate/check_auth.php');
    require '../incld/autoload.php';
    $mthd = $_SERVER['REQUEST_METHOD'];
    $conn  = new Model\Conn();
    $cntr  = new Contr\VehPassContr();
    switch($mthd) {            
        case "POST":
            if(isset($_POST['submit'])) {
                $rqst = json_decode(json_encode($_POST));
                $rqst->user_id = $_SESSION['user_id'];
                switch($rqst->submit) {
                    case 'ckiVeh' : 
                        $rqst->pstatus = 'CI';
                        $cntr->updtVPStatus($rqst);
                        $_SESSION['status'] = "Vehicle Checked IN";
                        break;
                    case 'recVeh' : 
                        $rqst->pstatus = 'VA';
                        $cntr->updtVPStatus($rqst);
                        $_SESSION['status'] = "Vehicle Received";
                        break;
                    case 'outVeh' :
                        $rqst->pstatus = 'CO';
                        $cntr->updtVPStatus($rqst);
                        $_SESSION['status'] = "Vehicle Checked-Out";
                        break;
                }
                $query = "select * from veh_data where pass_id = ?";
                $param = array($rqst->pass_id);
                $item  = $conn->execQuery($query,$param,1);
                $item->lifnr = (int)$item->lifnr;
                if(isset($_SESSION['pref_id'])) {
                    $page_id = $_SESSION['pref_id'];
                    header("location:".$page_id);
                }
            }
            break;
    }

    include('../incld/header.php');
    if(isset($_GET['pass_id'])) {
        $rqst = json_decode(json_encode($_GET));
        $query = "select * from veh_data where pass_id= ?";
        $param = array($rqst->pass_id);
        $item  = $conn->execQuery($query,$param,1);
        $item->lifnr = (int)$item->lifnr;
        $query = "select * from veh_item where pass_id = ?";
        $param = array($rqst->pass_id);
        $items = $conn->execQuery($query,$param);
        if(!isset($items)) {
            $item->cstat = 'XX';
            $_SESSION['status'] = 'There are no invoices in this Vehicle';
        }
    }
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
                                    <button type="submit" name="submit" class="btn btn-primary"   value="recVeh" <?php if( $item->cstat != 'VP') { echo 'disabled';} ?>>Receive</button>
                                    <button type="submit" name="submit" class="btn btn-success"   value="ckiVeh" <?php if( $item->cstat != 'SL') { echo 'disabled';} ?>>Check IN</button>
                                    <button type="submit" name="submit" class="btn btn-warning"   value="outVeh" <?php if( $item->cstat != 'SC') { echo 'disabled';} ?>>Check OUT</button>
                                    <button type="button" name="submit" class="btn btn-danger"    value="Close" onclick="window.close();"                              >Close</button>
                                </div>
                                <div class="form-group">
                                    <label for="">Vehicle No</label>
                                    <input type="text" name="zvehn"   class="form-control bg-primary" value="<?php echo $item->zvehn; ?>"   readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier</label>
                                    <input type="text" name="lifnr"  class="form-control " value="<?php echo "{$item->lifnr}_{$item->sname}"; ?>"   readonly >
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
