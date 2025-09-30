<?php
    session_start();
    include('../incld/verify.php');
    include('../gpent/check_auth.php');
    include('../incld/header.php');
    require '../incld/autoload.php';
    if(isset($_REQUEST['pass_id'])) {
        $pass_id = $_REQUEST['pass_id'];
    } else {
        $pass_id = "";
    }
    $cntr = new Contr\PassContr();
    $query = "select * from veh_data where pass_id = ?";
    $param = array($pass_id);
    $item  = $cntr->readPass($query,$param)[0];
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

                                <div class="form-group">
                                    <label for="">Usage Decision</label>
                                    <input type="text" name="zzins" class="form-control <?php echo $item->vccol; ?>" value="<?php echo $item->idesc; ?>"  readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Vehicle No</label>
                                    <input type="text" name="zvehn"   class="form-control bg-primary" value="<?php echo $item->zvehn; ?>"   readonly >
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
                                    <label for="">Pass ID</label>
                                    <input type="text" name="pass_id" class="form-control" value="<?php echo $item->pass_id; ?>" readonly >
                                </div>
                                <div class="form-group">
                                    <label for="">Gate Pass</label>
                                    <input type="text" name="zvpno" class="form-control"   value="<?php echo $item->zvpno; ?>"    readonly >
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
