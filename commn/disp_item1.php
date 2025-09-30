<?php
    require "../incld/verify.php";
    $incl = "incld";
    $role = $_SESSION['role_nm'];
    require "../{$role}/check_auth.php";
    require "../{$incl}/autoload.php";
    $role = $_SESSION['role_nm'];
    $util = new Model\Util();
    $sess = json_decode(json_encode($_SESSION));
    if(isset($_POST['action'])) {
        $rqst  = json_decode(json_encode($_POST));
        switch($rqst->action) {
            case 'updtLoc' :
                $query = "update veh_item 
                             set lgort = ?,
                                 charg = ?,
                                 zflag = 'A'
                           where objky = ? ";
                $param = array($rqst->lgort,$rqst->charg,$rqst->objky);
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
            case 'updtRmk':
                $util->writeLog(json_encode($rqst));
                $query = "update veh_item 
                             set zinsp = ?,
                                 zflag = 'A'
                           where objky = ? ";
                $param =  $param = array($rqst->zinsp,
                                         $rqst->objky);
                $util->execQuery($query,$param);
                $_SESSION['status'] = 'Inspection Remarks Updated';
                break;
            case 'updtQty' :
                $query = "update veh_item 
                             set charg = ?,
                                 zppbg = ?,
                                 zjtbg = ?,
                                 zrjbg = ?,
                                 zgqty = ?,
                                 zaqty = ?,
                                 zrqty = ?,
                                 zcomm = ?,
                                 zflag = 'U'
                           where objky = ? ";
                $param = array($rqst->charg,
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

    require "../{$incl}/header.php";
    require "../{$incl}/top_menu.php";
    require "../{$role}/side_menu.php"; 
    require "../{$role}/dashboard.php";
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
    
    $query = "select * from zmlc where matnr = ? and werks = ?";
    $param = array($item->matnr,$item->werks);
    $stloc = $util->execQuery($query,$param);
    $item->matnr = (int)$item->matnr;
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
                            <td> 
                                <label for="">Vehicle Status</label></td>
                            <td><input type="text" name="zcstat" class="form-control" value="<?php  echo $pass->sdesc; ?>" readonly ></td>
                            <td colspan="2" class="text-right">
                                <input type="hidden" name="zflag" id="zflag" value="<?php echo "{$item->zflag}"; ?>">
                                <input type="hidden" name="objky" id="zflag" value="<?php echo "{$item->objky}"; ?>">
                                <?php if($sess->role_nm == 'stloc') { ?>
                                <button type="submit" name="action" class="btn btn-success"   value="updtLoc" <?php if( $item->zflag != 'Q') { echo 'disabled';} ?>>Update Loc</button>
                                <button type="submit" name="action" class="btn btn-warning"   value="updtQty" <?php if( $item->zflag != 'A') { echo 'disabled';} ?>>Update Qty</button>
                                <?php } ?>
                                <?php if($sess->role_nm == 'qinsp') { ?>
                                <button type="submit" name="action" class="btn btn-warning"   value="updtRmk" <?php if( $item->zflag != 'S') { echo 'disabled';} ?>>updt Remark</button>
                                <?php } ?>
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
                                <label for="">Pass Date</label>
                                <input type="text" name="erdat" class="form-control" value="<?php echo $pass->erdat; ?>" readonly >
                                
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
                                <input type="hidden" name="xchar" id="xchar" value="<?php echo $item->xchar; ?>">
                                <label for="">Batch</label>
                                <input type="text" name="charg" id="charg" class="form-control"   value="<?php echo $item->charg; ?>"  readonly <?php if($item->xchar == 'X') { echo "required";}?>>
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
                                <label for="">Insp Remarks</label>
                                <input type="text" name="zinsp" id="zinsp" class="form-control "   value="<?php echo $item->zinsp; ?>"    readonly >
                                
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="4">
                                <label for="">Store Remarks</label>
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
    <script>
        $(document).ready(function(){
            let zflag = $('#zflag').val();
            let xchar = $('#xchar').val();
            switch(zflag) {
                case 'Q' :
                    $('#lgort').prop('disabled', false);
                    if (xchar == 'X' ) {
                        $('#charg').prop('readonly', false);
                    }
                    
                    break;
                case 'S' :
                    $('#zinsp').prop('readonly', false);
                    break; 
                case 'A' :
                    $('#lgort').prop('disabled', false);
                    if (xchar == 'X' ) {
                        $('#charg').prop('readonly', false);
                    }
                    $('#zppbg').prop('readonly', false);
                    $('#zjtbg').prop('readonly', false);
                    $('#zcomm').prop('readonly', false); 
                    break;
                case 'U' :
                    $('#zppbg').prop('readonly', false);
                    $('#zjtbg').prop('readonly', false);
                    break;
            }
        });
        function calcBag() {
            debugger;
            zchbg = $('#zchbg').val();
            zppbg = $('#zppbg').val();
            zjtbg = $('#zjtbg').val();
            zrjbg = Number(zchbg) - Number(zppbg) - Number(zjtbg);
            zgqty = Number(zchbg) * 50;
            zaqty = (Number(zppbg) + Number(zjtbg))* 50;
            zrqty = Number(zrjbg) * 50;

            $('#zrjbg').val(zrjbg);
            $('#zgqty').val(zgqty);
            $('#zaqty').val(zaqty);
            $('#zrqty').val(zrqty);
        }
    </script>
<?php
    include('../incld/footer.php');
?>
