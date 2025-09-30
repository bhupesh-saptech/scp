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
    $query = "select * from zmvt where ebeln = COALESCE(NULLIF(@ebeln, ''), :ebeln) and ebelp = COALESCE(NULLIF(@ebelp, ''), :ebelp) and lifnr = :lifnr and bwart = '105' ";
    $param = array($rqst->ebeln,$rqst->ebelp,$sess->supp_id);
    $items = $conn->execQuery($query,$param);

?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Goods Movements</div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order No</th>
                    <th>Item</th>
                    <th>Mat Doc</th>
                    <th>DYear</th>
                    <th>Ln</th>
                    <th>Pstg Date</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Plant</th>
                    <th>MvT</th>
                    <th>GRN Qty</th>
                    <th>UoM</th>

                </tr>
            </thead>
            <?php
                $summ = new stdClass();
                $summ->menge = 0; 
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->matnr = ltrim($item->matnr,'0');
                        $summ->menge = $summ->menge + $item->menge;
            ?>
                    <tr>
                        <td><?php echo $item->ebeln; ?></td>            
                        <td><?php echo $item->ebelp; ?></td>           
                        <td><?php echo $item->mblnr; ?></td>           
                        <td><?php echo $item->mjahr; ?></td>           
                        <td><?php echo $item->zeile; ?></td>           
                        <td><?php echo $item->budat; ?></td>           
                        <td><?php echo $item->matnr; ?></td>
                        <td><?php echo $item->txz01; ?></td>           
                        <td><?php echo $item->werks; ?></td>                  
                        <td><?php echo $item->bwart; ?></td>           
                        <td class="text-right"><?php echo $item->menge; ?></td>   
                        <td><?php echo $item->meins; ?></td>          
                    </tr>
            <?php 
                    } 
                }
            ?>
            <tfoot>
                <tr>
                    <th class="text-right"colspan="10">Total :</th>
                    <th class="text-right"><?php echo number_format($summ->menge,3); ?></th>
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