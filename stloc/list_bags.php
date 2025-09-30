<?php
    session_start();
    require '../incld/autoload.php';
    $conn = new Model\Conn();
    $cntr = new Contr\VehPassContr();
    if(isset($_POST['action'])) {
        $rqst = json_decode(json_encode($_POST));
        $rqst->user_id = $_SESSION['user_id'];
        $query = "update veh_item 
                     set zpmat = :zpmat,
                         zpqty = :zpqty,
                         zpuom = :zpuom,
                         zcomm = :zcomm
                   where pass_id = :pass_id
                     and chln_id = :chln_id
                     and item_id = :item_id";
        $param = array( ':zpmat'   => $rqst->zpmat,
                        ':zpqty'   => $rqst->zpqty,
                        ':zpuom'   => $rqst->zpuom,
                        ':zcomm'   => $rqst->zcomm,
                        ':pass_id' => $rqst->pass_id,
                        ':chln_id' => $rqst->chln_id,
                        ':item_id' => $rqst->item_id);
        $items = $conn->execQuery($query,$param);
        $_SESSION['status'] = "Uloading Details updated";
        $query = "select * from veh_item where pass_id = :pass_id and lgort = ''";
        $param = array(':pass_id'=>$rqst->pass_id);
        $items = $conn->execQuery($query,$param);
        if(!isset($items)) {
            $query = "update veh_pass set cstat = 'SL' where pass_id = :pass_id";
            $param = array(':pass_id'=>$rqst->pass_id);
            $items = $conn->execQuery($query,$param);
            $rqst->pstatus = 'UL';
            $cntr->updtVPStatus($rqst);
            $_SESSION['status'] = "Unloading Details Updated";   
        }
    }
    require '../incld/verify.php';
    require '../stloc/check_auth.php';
    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../stloc/side_menu.php'; 
    require '../stloc/dashboard.php';

    $rqst = json_decode(json_encode($_GET));
    
    $query = "select * from veh_data where pass_id = ?";
    $param = array($rqst->pass_id);
    $pass = $conn->execQuery($query,$param,1);

    $query = "select * from stor_loc";
    $param = array();
    $stloc = $conn->execQuery($query,$param);
    
    $query = "select a.*,
                    b.chln_no,
                    b.chln_dt
               from veh_item as a 
               inner join veh_chln as b 
                  on b.pass_id = a.pass_id 
                 and b.chln_id = a.chln_id
                where a.pass_id = ? ";
    $param = array($rqst->pass_id);
    $items = $conn->execQuery($query,$param);
?>
<div class="card ">
    <div class="card-header">
        <?php include('../incld/messages.php'); ?>
        <h4 class="card-title">Update Bag Details for a Line Item</h4>
        <button type="button" class="btn btn-danger float-right" onclick="window.history.back();">Back</button>
        
    </div>
    <div class="row bg-dark">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr class="bg-dark">
                    <th class="col-sm-2">
                        <label for="">Vehicle Number</label>
                        <input type="text" name="zvehno"   class="form-control"  value="<?php echo $pass->zvehn;   ?>" disabled>
                    </th>
                    <th class="col-sm-2">
                        <label for="">Transporter</label>
                        <input type="text" name="ztnam"   class="form-control"  value="<?php echo $pass->ztnam;   ?>" disabled>
                    </th>
                    <th class="col-sm-2">
                        <label for="">Driver Name</label>
                        <input type="text" name="zdnam"   class="form-control"  value="<?php echo $pass->zdnam;   ?>" disabled>
                    </th>
                    <th class="col-sm-1">
                        <label for="">Contact</label>
                        <input type="text" name="zmbno"   class="form-control"  value="<?php echo $pass->zmbno;   ?>" disabled>
                    </th>
                    <th class="col-sm-2">
                        <label for="">LR Number</label>
                        <input type="text" name="zlrno"   class="form-control"  value="<?php echo $pass->zlrno;   ?>" disabled>
                    </th>
                    <th class="col-sm-1">
                        <label for="">LR Date</label>
                        <input type="date" name="zlrdt"   class="form-control"  value="<?php echo $pass->zlrdt;  ?>" disabled >
                    </th>
                    <th class="col-sm-2">
                        <label for="">Vehicle Pass</label>
                        <input type="text" name="pass_id"  class="form-control"  value="<?php echo $pass->pass_id; ?>" disabled>       
                    </th>
                </tr>
            </table>
        </div> 
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>PO Num</th>
                    <th>Material</th>
                    <th>Chln Qty</th>
                    <th>UoM</th>
                    <th>Plant</th>
                    <th>StLoc</th>
                    <th>Bag Type</th>
                    <th>UoM</th>
                    <th>Bag Count</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { 
                    $item->matnr = ltrim($item->matnr,'0');
        ?>
                    
                    <tr>
                        <td>
                            <form method="post">
                            <input type="hidden" name="pass_id" value="<?php echo "{$item->pass_id}" ;  ?>">
                            <input type="hidden" name="chln_id" value="<?php echo "{$item->chln_id}" ;  ?>">
                            <input type="hidden" name="item_id" value="<?php echo "{$item->item_id}" ;  ?>">
                            <?php echo "{$item->ebeln}_{$item->ebelp}";  ?>
                        </td>
                        <td><?php echo "{$item->matnr}_{$item->txz01}";  ?></td>
                        <td class="text-right"><?php echo "{$item->lfimg}"   ;  ?></td>
                        <td><?php echo "{$item->vrkme}"   ;  ?></td>
                        <td><?php echo "{$item->werks}"   ;  ?></td>
                        <td>
                            <select name="lgort" class="form-control" required>
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
                            <select name="zpmat" class="form-control" <?php if($pass->cstat != 'GW') {echo 'disabled';}?>>
                                <option value=""      <?php if($item->zpmat == ''     ) { echo 'selected';} ?>>select Packing Type</option>
                                <option value="PPBAG" <?php if($item->zpmat == 'PPBAG') { echo 'selected';} ?>>PPBAG : PP Bag     </option>
                                <option value="JTBAG" <?php if($item->zpmat == 'JTBAG') { echo 'selected';} ?>>JTBAG : Jute Bag   </option>
                            </select>
                        </td>
                        <td>
                            <select name="zpuom" class="form-control" <?php if($pass->cstat != 'GW') {echo 'disabled';}?>>
                                <option value=""    <?php if($item->zpuom == ''   ) { echo 'selected';} ?>>Select UoM</option>
                                <option value="BAG" <?php if($item->zpuom == 'BAG') { echo 'selected';} ?>>BAG</option>
                                <option value="NOS" <?php if($item->zpuom == 'NOS') { echo 'selected';} ?>>NOS</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="zpqty" class="form-control text-right" value="<?php echo "{$item->zpqty}";?>" <?php if($pass->cstat != 'GW') {echo 'readonly';}?>>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" name="zcomm" class="form-control" value="<?php echo "{$item->zcomm}" ;  ?> <?php if($pass->cstat != 'GW') {echo 'readonly';}?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="action" value="updtBags">
                                        <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        </form>
                    </tr>
        <?php   }
            } 
        ?>
            </tbody> 
        </table>
    </div>
</div>


<?php
    include('../incld/jslib.php');
?>
<script>
    function newTab(url) {
        window.open(url,'_blank');
    }
</script>
<?php
    include('../incld/footer.php');
?>