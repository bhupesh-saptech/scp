<?php 
    include('../incld/verify.php');
    include('../suppl/check_auth.php');
    include('../incld/header.php');
    include('../incld/top_menu.php');
    include('../suppl/side_menu.php');
    include('../suppl/dashboard.php');
    require '../incld/autoload.php';
    $sess = json_decode(json_encode($_SESSION));
    if(isset($_GET['ebeln'])) {
        $rqst = json_decode(json_encode($_GET));
    } else {
        $rqst = new stdClass();
        $rqst->ebeln = "";
        $rqst->ebelp = "";
    }
    $conn = new Model\Util();
    $query = "select * from zibd where vgbel = COALESCE(NULLIF(@vgbel, ''), :ebeln) and vgpos = COALESCE(NULLIF(@vgpos, ''), :ebelp) and lifnr = :lifnr";
    $param = array($rqst->ebeln,$rqst->ebelp,$sess->supp_id);
    $items = $conn->execQuery($query,$param);
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
                    <th>Delivery</th>
                    <th>Del Item</th>
                    <th>Del Date</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Plant</th>
                    <th>StLoc</th>
                    <th>Del Qty</th>
                    <th>UoM</th>
                </tr>
            </thead>
            <?php 
                $summ = new stdClass();
                $summ->lfimg = 0;
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->lifnr = ltrim($item->lifnr,'0');
                        $summ->lfimg = $summ->lfimg + $item->lfimg;
            ?>
                    <tr>
                        <td><?php echo $item->vbeln; ?></td>
                        <td><?php echo $item->posnr; ?></td>
                        <td><?php echo $item->erdat; ?></td>          
                        <td><?php echo $item->matnr; ?></td>          
                        <td><?php echo $item->arktx; ?></td>          
                        <td><?php echo $item->werks; ?></td>          
                        <td><?php echo $item->lgort; ?></td>
                        <td class="text-right"><?php echo $item->lfimg; ?></td>
                        <td><?php echo $item->vrkme; ?></td>
                    </tr>
            <?php 
                    } 
                }
            ?>
            <tfoot>
                <tr>
                    <th class="text-right"colspan="7">Total :</th>
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