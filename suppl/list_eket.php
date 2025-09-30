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
    $conn = new Model\Util();
    $query = "select * from zpos where ebeln = COALESCE(NULLIF(@ebeln, ''), :ebeln) and ebelp = COALESCE(NULLIF(@ebelp, ''), :ebelp) and lifnr = :lifnr ";
    $param = array($rqst->ebeln,$rqst->ebelp,$sess->supp_id);
    $items = $conn->execQuery($query,$param);

?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Purchase Order Delivery Schedule</div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Order Item</th>
                    <th>SchLine</th>
                    <th>Sch Date</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Sch Qty</th>
                    <th>Del Qty</th>
                    <th>Bal Qty</th>
                </tr>
            </thead>
            <?php
                $summ = new stdClass();
                $summ->menge = 0;
                $summ->wemng = 0;
                $summ->shmng = 0; 
                if(isset($items)) {
                    foreach($items as $item) { 
                        $item->matnr = ltrim($item->matnr,'0');
                        $item->shmng = number_format($item->menge - $item->wemng,3);
                        $summ->menge = $summ->menge + $item->menge;
                        $summ->wemng = $summ->wemng + $item->wemng;
                        $summ->shmng = $summ->shmng + $item->shmng;
            ?>
                    <tr>
                        <td><?php echo $item->ebeln; ?></td>
                        <td><?php echo $item->ebelp; ?></td>
                        <td><?php echo $item->etenr; ?></td>
                        <td><?php echo $item->eindt; ?></td>
                        <td><?php echo $item->matnr; ?></td>
                        <td><?php echo $item->txz01; ?></td>
                        <td class="text-right"><?php echo $item->menge; ?></td>
                        <td class="text-right"><?php echo $item->wemng; ?></td>
                        <td class="text-right"><?php echo $item->shmng; ?></td>
                    </tr>
            <?php 
                    }
                }
            ?>
            <tfoot>
                <tr>
                    <th class="text-right"colspan="6">Total :</th>
                    <th class="text-right"><?php echo number_format($summ->menge,3); ?></th>
                    <th class="text-right"><?php echo number_format($summ->wemng,3); ?></th>
                    <th class="text-right"><?php echo number_format($summ->shmng,3); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php
    include('../incld/jslib.php');
    include('../incld/footer.php');
?>