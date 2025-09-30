<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/header.php';
    require '../suppl/top_menu.php';
    require '../suppl/side_menu.php';
    require '../suppl/dashboard.php';
    require '../incld/autoload.php';

    $util = new Model\Util();
    $sess = json_decode(json_encode($_SESSION));
    if(isset($_GET['ebeln'])) {
        $rqst = json_decode(json_encode($_GET));
    } else {
        $rqst = new stdClass();
        $rqst->ebeln = "";
        $rqst->ebelp = "";
    }
    
    $query = "select * from veh_item where ebeln = COALESCE(NULLIF(@ebeln, ''), :ebeln) and ebelp = COALESCE(NULLIF(@ebelp, ''), :ebelp) and md103 is null";
    $param = array($rqst->ebeln,$rqst->ebelp);
    $items = $util->execQuery($query,$param);
?>
<div class="card">
    <div class="card-header">
      <div class="card-title">Material Gate Entry</div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:20%">PO Item</th>
                    <th style="width:10%">PassID</th>
                    <th style="width:10%">Material</th>
                    <th style="width:30%">Description</th>
                    <th style="width:10%">Plant</th>
                    <th style="width:10%">Del Qty</th>
                    <th style="width:10%">UoM</th>
                </tr>
            </thead>
            <?php 
                $summ = new stdClass();
                $summ->lfimg = 0;
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->pitem = $item->ebeln.$item->ebelp;
                        $item->matnr = (int)$item->matnr;
                        $summ->lfimg = $summ->lfimg + $item->lfimg;
            ?>
                    <tr>
                        <td><?php echo $item->pitem;  ?></td>
                        <td><?php echo $item->pass_id;?></td>          
                        <td><?php echo $item->matnr;  ?></td>          
                        <td><?php echo $item->txz01;  ?></td>          
                        <td><?php echo $item->werks;  ?></td>          
                        <td class="text-right"><?php echo $item->lfimg; ?></td>
                        <td><?php echo $item->vrkme; ?></td>
                    </tr>
            <?php 
                    } 
                }
            ?>
            <tfoot>
                <tr>
                    <th class="text-right"colspan="5">Total :</th>
                    <th class="text-right"><?php echo number_format($summ->lfimg,3); ?></th>
                    <th></th>
                </tr>
            </tfoot>    
        </table>
    </div>
</div>

<?php
    include('../incld/jslib.php');
    include('../incld/footer.php');
?>

