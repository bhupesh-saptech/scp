<?php
    session_start();
    
    include('../incld/verify.php');
    include('../suppl/check_auth.php');
    include('../incld/header.php');
    require '../incld/autoload.php';
    $rqst = json_decode(json_encode($_GET));
    $conn  = new Model\Conn();
    $query = "select * from veh_data where pass_id= ?";
    $param = array($rqst->pass_id);
    $item  = $conn->execQuery($query,$param,1);
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
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <label for="">Usage Decision</label>
                                        <input type="text" name="zzins" class="form-control <?php echo $item->vccol; ?>" value="<?php echo $item->idesc; ?>" readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Vehicle No</label>
                                        <input type="text" name="zvehn"   class="form-control bg-primary" value="<?php echo $item->zvehn; ?>"   readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Transporter</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="ztnam"   class="form-control" value="<?php echo $item->ztnam; ?>"   readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Driver Name</label>
                                        <input type="text" name="zdnam" class="form-control" value="<?php echo $item->zdnam;?>"    readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Driver Phone</label>
                                        <input type="text" name="zmbno"   class="form-control" value="<?php echo $item->zmbno; ?>"   readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Pass ID</label>
                                        <input type="text" name="pass_id" class="form-control" value="<?php echo $item->pass_id; ?>" readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Gate Pass</label>
                                        <input type="text" name="zvpno" class="form-control"   value="<?php echo $item->zvpno; ?>"    readonly >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">Shipment</label>
                                        <input type="text" name="tknum" class="form-control"   value="<?php echo $item->tknum; ?>"    readonly >
                                    </td>
                                </tr>
                            </table>    
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
