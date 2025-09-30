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
    $query = "select * from zinv where ebeln = COALESCE(NULLIF(@ebeln, ''), :ebeln) and ebelp = COALESCE(NULLIF(@ebelp, ''), :ebelp) and lifnr = :lifnr ";
    $param = array($rqst->ebeln,$rqst->ebelp,$sess->supp_id);
    $items = $conn->execQuery($query,$param);
?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Vendor Invoice Verification</div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>PO Num</th>
                    <th>Item</th>
                    <th>CC</th>
                    <th>Doc No</th>
                    <th>DYr</th>
                    <th>Ln</th>
                    <th>Inv No</th>
                    <th>Inv Dt</th>
                    <th>Pstg Dt</th>
                    <th>GR Num</th>
                    <th>GRYr</th>
                    <th>Item</th>
                    <th>Miro Value</th>
                </tr>
            </thead>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->lifnr = ltrim($item->lifnr,'0');
            ?>
                    <tr>
                        <td><?php echo $item->ebeln; ?></td>           
                        <td><?php echo $item->ebelp; ?></td>           
                        <td><?php echo $item->bukrs; ?></td>           
                        <td><?php echo $item->belnr; ?></td>           
                        <td><?php echo $item->gjahr; ?></td>           
                        <td><?php echo $item->buzei; ?></td>           
                        <td><?php echo $item->xblnr; ?></td>           
                        <td><?php echo $item->bldat; ?></td>           
                        <td><?php echo $item->budat; ?></td>           
                        <td><?php echo $item->lfbnr; ?></td>           
                        <td><?php echo $item->lfgja; ?></td>           
                        <td><?php echo $item->lfbln; ?></td>           
                        <td><?php echo $item->wrbtr; ?></td>           
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