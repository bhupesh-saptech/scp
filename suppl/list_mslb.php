<?php 
    include('../incld/verify.php');
    include('../incld/header.php');
    include('../suppl/top_menu.php');
    include('../suppl/side_menu.php');
    require '../suppl/dashboard.php';
    include('../incld/dbconn.php');
    if (isset($_SESSION['supp_id'])) {
        $lifnr = $_SESSION['supp_id'];
        $dtset = $conn->query("select * from zsub where lifnr = '$lifnr'");
        $items = json_decode(json_encode($dtset->fetch_all(MYSQLI_ASSOC)));
    }
    $conn->close();
?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Subcontracting Stocks</div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Material</th>
                    <th>Description</th>
                    <th>Plant</th>
                    <th>Batch</th>
                    <th>Unre Stock </th>
                    <th>Insp Stock</th>
                </tr>
            </thead>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->lifnr = ltrim($item->lifnr,'0');
                        $item->matnr = ltrim($item->matnr,'0');
            ?>
                    <tr>
                        <td><?php echo $item->lifnr; ?></td>
                        <td><?php echo $item->matnr; ?></td>
                        <td><?php echo $item->txz01; ?></td>          
                        <td><?php echo $item->werks; ?></td>          
                        <td><?php echo $item->charg; ?></td>          
                        <td><?php echo $item->lblab; ?></td>          
                        <td><?php echo $item->lbins; ?></td>          
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