<?php

    require '../incld/verify.php';
    require '../stloc/check_auth.php';
    require '../incld/autoload.php';

    
    $util = new Model\Util();
    if(isset($_POST['action'])) {
        $rqst  = json_decode(json_encode($_POST));
        switch($rqst->action) {
            case 'updtLoc' :
                $query = "update veh_item 
                             set lgort = ?,
                                 zflag = 'S'
                           where objky = ? ";
                $param = array($rqst->lgort,$rqst->objky);
                $util->execQuery($query,$param);
                $_SESSION['status'] = 'Storage Location Updated';
                $query = "select count(*) as count,COUNT(IF(zflag = 'S', 1, NULL)) as slcnt from veh_item where pass_id = ?";
                $param = array(substr($rqst->objky,0,10));
                $item = $util->execQuery($query,$param,1);
                if($item->count == $item->slcnt) {
                    $rqst->pstatus = 'SL';
                    $query = "update veh_pass set cstat = ? where objky = ?";
                    $param = array( $rqst->pstatus,substr($rqst->objky,0,10));
                    $items  = $util->execQuery($query,$param);
                    $_SESSION['status'] = 'Storage Location Updation Complete';
                }    
                break;
            case 'updtQty' :
                $query = "update veh_item 
                             set lgort = ?,
                                 charg = ?,
                                 zppbg = ?,
                                 zjtbg = ?,
                                 zrjbg = ?,
                                 zgqty = ?,
                                 zaqty = ?,
                                 zrqty = ?,
                                 zcomm = ?,
                                 zflag = 'U'
                           where objky = ? ";
                $param = array($rqst->lgort,
                               $rqst->charg,
                               $rqst->zppbg,
                               $rqst->zjtbg,
                               $rqst->zrjbg,
                               $rqst->zgqty,
                               $rqst->zaqty,
                               $rqst->zrqty,
                               $rqst->zcomm,
                               $rqst->objky);
                $util->execQuery($query,$param);  
                $_SESSION['status'] = 'Storage Location Updated';  
                 $query = "select count(*) as count,COUNT(IF(zflag = 'U', 1, NULL)) as slcnt from veh_item where pass_id = ?";
                $param = array(substr($rqst->objky,0,10));
                $item  = $util->execQuery($query,$param,1);
                if($item->count == $item->slcnt) {
                    $rqst->pstatus = 'UL';
                    $query = "update veh_pass set cstat = ? where objky = ?";
                    $param = array( $rqst->pstatus,substr($rqst->objky,0,10));
                    $items  = $util->execQuery($query,$param);
                    $_SESSION['status'] = 'Unloading Complete';
                }     
                break;
        }
        if(isset($_SESSION['pref_id'])) {
            $page_id = $_SESSION['pref_id'];
            header("location:".$page_id);
        }   
    }

    include('../incld/header.php');
    require '../incld/top_menu.php';
    require '../stloc/side_menu.php'; 
    require '../stloc/dashboard.php';
    if(isset($_GET['objky'])) {
        $rqst  = json_decode(json_encode($_GET));
    }
  
    $query = "select * from veh_data where objky = ?";
    $param = array(substr($rqst->objky,0,10));
    $pass  = $util->execQuery($query,$param,1);


    $query = "select * from veh_chln where objky = ?";
    $param = array(substr($rqst->objky,0,12));
    $chln  = $util->execQuery($query,$param,1);

    $query = "select * from veh_item where objky = ?";
    $param = array($rqst->objky);
    $item  = $util->execQuery($query,$param,1);
    $item->matnr = (int)$item->matnr;

    $query = "select * from stor_loc";
    $param = array();
    $stloc = $util->execQuery($query,$param);

?>        

<div class="card card-primary">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-header">
                <h3 class="card-title">Vehicle Challan Item Details</h3>
                <?php include('../incld/messages.php'); ?>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
            </div>
            <div class="col-md-8">
                <form method="POST"  >
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="4" class="text-right">
                                
                                <!-- <input type="hidden" name="zflag" id="zflag" value="<?php echo "{$item->zflag}"; ?>">
                                <input type="hidden" name="objky" id="zflag" value="<?php echo "{$item->objky}"; ?>">
                                <button type="submit" name="action" class="btn btn-success"   value="updtLoc" <?php if( $item->zflag != 'Q') { echo 'disabled';} ?>>Update Loc</button>
                                <button type="submit" name="action" class="btn btn-warning"   value="updtQty" <?php if( $item->zflag != 'S') { echo 'disabled';} ?>>Update Qty</button> -->
                                <button type="button" name="action" class="btn btn-danger"    value="Close" onclick="window.close();"                              >Close</button>
                            </td>
                        </tr>
                            <td>                                    
                                <label for="">Vehicle No</label>
                                <input type="text" name="zvehn"   class="form-control bg-primary" value="<?php echo $pass->zvehn; ?>"   readonly >
                            </td>
                            <td>
                                <label for="">Vehicle Pass</label>
                                <input type="text" name="pass_id" class="form-control" value="<?php echo $pass->pass_id; ?>" readonly >
                            </td>
                            <td>
                                <label for="">Vehicle Status</label>
                                <input type="text" name="zcstat" class="form-control" value="<?php  echo $pass->sdesc; ?>" readonly >
                            </td>
                            <td>
                                <label for="">Shipment</label>
                                <input type="text" name="ztknum" class="form-control"   value="<?php echo $pass->tknum; ?>"    readonly >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Purchase Order</label>
                                <input type="text" name="ebeln" class="form-control " value="<?php echo $item->ebeln; ?>" readonly >
                            </td>
                            <td>
                                <label for="">PO Item</label>
                                <input type="text" name="ebelp"   class="form-control" value="<?php echo $item->ebelp; ?>"   readonly >
                            </td>
                            <td>
                                <label for="">Material</label>
                                <input type="text" name="matnr" class="form-control" value="<?php echo $item->matnr;?>"    readonly >
                            </td>
                        
                            <td>
                                <label for="">Description</label>
                                <input type="text" name="txz01"   class="form-control" value="<?php echo $item->txz01; ?>"   readonly >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Plant</label>
                                <input type="text" name="werks" class="form-control"   value="<?php echo $item->werks; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Storage Loc</label>
                                <select name="lgort" id="lgort" class="form-control" required disabled >
                                    <option value="">Select StLoc</option>
                                    <?php   foreach($stloc as $sloc) { 
                                                if($sloc->werks == $item->werks) {
                                    ?>
                                        <option value="<?php echo "{$sloc->lgort}"; ?>" <?php if($sloc->lgort == $item->lgort) { echo 'selected';} ?>><?php echo "{$sloc->lgort}_{$sloc->objnm}"; ?></option>
                                    <?php       } 
                                            }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <label for="">Batch</label>
                                <input type="text" name="charg" id="charg" class="form-control"   value="<?php echo $item->charg; ?>"  readonly required>
                            </td>
                            <td>
                                <label for="">UoM</label>
                                <input type="text" name="vrkme" class="form-control text-right"   value="<?php echo $item->vrkme; ?>"    readonly >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Challan Bags</label>
                                <input type="text" name="zchbg" id="zchbg" class="form-control text-right"   value="<?php echo $item->zchbg; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">PP Bags</label>
                            <input type="text" name="zppbg" id="zppbg" class="form-control text-right"  oninput="calcBag();" value="<?php echo $item->zppbg; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Jute Bags</label>
                                <input type="text" name="zjtbg" id="zjtbg" class="form-control text-right" oninput="calcBag();"  value="<?php echo $item->zjtbg; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Reject Bags</label>
                                <input type="text" name="zrjbg" id="zrjbg" class="form-control text-right"   value="<?php echo $item->zrjbg; ?>"    readonly >
                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Delivery Qty</label>
                                <input type="text" name="lfimg" class="form-control text-right"   value="<?php echo $item->lfimg; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Received Qty</label>
                                <input type="text" name="zgqty" id="zgqty" class="form-control text-right"   value="<?php echo $item->zgqty; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Accepted Qty</label>
                                <input type="text" name="zaqty" id="zaqty" class="form-control text-right"   value="<?php echo $item->zaqty; ?>"    readonly >
                            </td>
                            <td>
                                <label for="">Rejected Qty</label>
                                <input type="text" name="zrqty" id="zrqty" class="form-control text-right"   value="<?php echo $item->zrqty; ?>"    readonly >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label for="">Comments</label>
                                <input type="text" name="zcomm" id="zcomm" class="form-control "   value="<?php echo $item->zcomm; ?>"    readonly >
                                
                            </td>
                        </tr>       
                    </table>
                </form>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    </div>
</div>
<?php
    include('../incld/jslib.php');
?>
<?php
    include('../incld/footer.php');
?>
