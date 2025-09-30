<?php 
    require '../incld/verify.php';
    require '../incld/header.php';
    require '../suppl/top_menu.php';
    require '../suppl/side_menu.php';
    require '../suppl/dashboard.php';
    require '../incld/autoload.php';
    $sess = json_decode(json_encode($_SESSION));
    if(isset($_GET['ebeln'])) {
        $rqst = json_decode(json_encode($_GET));
    } else {
        $rqst = new stdClass();
        $rqst->ebeln = "";
        $rqst->ebelp = "";
    }
    if(isset($_POST['filter'])) {
        $rqst = $rqst = json_decode(json_encode($_POST));
        $dt_from = $rqst->dt_from;
        $dt_upto = $rqst->dt_upto;
        $po_stat = $rqst->po_stat;
    } else {
        $dt_from = $sess->from_dt;
        $dt_upto = $sess->upto_dt;
        $po_stat = 'A';
    }
    $conn = new Model\Util();
    switch($po_stat) {
        case 'A' :
            $query = "select * from zpoi_view where lifnr = ?  and bedat between ? and ? ";
            break;
        case 'C' :
            $query = "select * from zpoi_view where lifnr = ?  and bedat between ? and ? and ntmng <= 0 and eindt < curdate() ";
            break;
        case 'O' :
            $query = "select * from zpoi_view where lifnr = ?  and bedat between ? and ? and ntmng > 0 and eindt >= curdate() ";
            break;
    }
    $param = array($sess->supp_id,$dt_from,$dt_upto);
    $items = $conn->execQuery($query,$param);
?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Purchase Order Details</div>
            <form method="post"> 
                <table class="table table-bordered table-stripped">
                    <tr class="bg-dark">
                        <td style="width:50%">
                            <h3> Purchase Order Filter </h3>  
                        </td>
                        <td style="width:15%">
                            <label for="" class="form-label mt-2">From Date</label>
                            <input type="date" class="form-control" name="dt_from" value="<?php echo "{$dt_from}"; ?>">
                        </td>
                        <td style="width:15%">
                            <label for="" class="form-label mt-2">Upto Date</label>
                            <input type="date" class="form-control" name="dt_upto" value="<?php echo "{$dt_upto}"; ?>">
                        </td>
                        <td style="width:30%">
                            <label for="" class="form-label mt-2">Pur Order Status</label>
                            <div class="input-group mb-3">
                                <select name="po_stat" class="form-control" >
                                    <option value=""  <?php if($po_stat == "" ) {echo "selected" ;} ?>>Select Status</option>
                                    <option value="O" <?php if($po_stat == "O") {echo "selected" ;} ?>>Open  POs   </option>
                                    <option value="C" <?php if($po_stat == "C") {echo "selected" ;} ?>>Close POs   </option>
                                    <option value="A" <?php if($po_stat == "A") {echo "selected" ;} ?>>All   POs   </option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="filter" value="filter">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div> 
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:12%;">PO Item</th>
                    <th style="width:08%;">PO Date</th>
                    <th style="width:18%;">Material</th>
                    <th style="width:06%;">Plant</th>
                    <th style="width:16%;">Broker Name</th>
                    <th style="width:08%;">ORD Qty</th>
                    <th style="width:08%;">Del Date</th>
                    <th style="width:08%;">GRN Qty</th>
                    <th style="width:08%;">CHL Qty</th>
                    <th style="width:08%;">BAL  Qty</th>
                </tr>
            </thead>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) {
                        $query = "select * from zpoc where ebeln = ? and ebelp = ?";
                        $param = array($item->ebeln,$item->ebelp);
                        $cond  = $conn->execQuery($query,$param,1);
                        if(!isset($cond)) {
                            $cond = new stdClass();
                            $cond->lifnr = "";
                            $cond->name1 = "";
                        } else {
                            $cond->lifnr = ltrim($cond->lifnr,'0');
                        }
                        $item->lifnr = ltrim($item->lifnr,'0');
                        $item->matnr = ltrim($item->matnr,'0');
                        $item->txz01 = substr($item->txz01,0,20);
            ?>
                    <tr>
                        <td><?php echo $item->objky; ?></td>
                        <td><?php echo $item->bedat; ?></td>
                        <td><?php echo "{$item->matnr}_{$item->txz01}"; ?></td>
                        <td><?php echo $item->werks; ?></td>
                        <td><?php echo "{$cond->lifnr}_{$cond->name1}"; ?></td>
                        <td class="text-right"><?php echo $item->menge; ?></td>
                        <td class="text-right"><?php echo $item->eindt; ?></td>
                        <td class="text-right"><a  href="<?php echo "../suppl/list_migo.php?ebeln={$item->ebeln}&ebelp={$item->ebelp}"; ?>"><?php echo $item->wemng; ?></a></td>
                        <td class="text-right"><a  href="<?php echo "../suppl/list_item.php?ebeln={$item->ebeln}&ebelp={$item->ebelp}"; ?>"><?php echo $item->chqty; ?></a></td>
                        <td class="text-right"><a  href="<?php echo "../suppl/list_eket.php?ebeln={$item->ebeln}&ebelp={$item->ebelp}"; ?>"><?php echo $item->ntmng; ?></a></td>
                    </tr>
            <?php 
                    } 
                }
            ?>
        </table>
    </div>
</div>


<?php
    include('../incld/jslib.php');
    include('../incld/footer.php');
?>