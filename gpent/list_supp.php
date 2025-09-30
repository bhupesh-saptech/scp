<?php 
    require '../incld/verify.php';
    require '../gpent/check_auth.php';
    require '../incld/autoload.php';
  
    $conn = new Model\Util();

    if(isset($_GET['action'])) {
        $rqst = json_decode(json_encode($_GET));
        $_SESSION['supp_id'] = $rqst->supp_id;
        $conn->writeLog(json_encode($rqst));
        header('location: ../suppl/index.php');
        exit;
    }

    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../gpent/side_menu.php';
    require '../gpent/dashboard.php';
    $query = "select * from supplier";
    $param = array();
    $items = $conn->execQuery($query,$param);
?>
<div class="card">
    <div class="card-header">
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th>Supplier Name</th>
                    <th>Country</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Pin Code</th>
                    <th>Type</th>
                    <th>Pur.Group</th>
                    <th>Supplier</th> 
                </tr>
            </thead>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->supp_id = $item->lifnr;
                        $item->lifnr = ltrim($item->lifnr,'0');
            ?>
                <tr>
                    <td><?php echo $item->objnm; ?></td>      
                    <td><?php echo $item->land1; ?></td>      
                    <td><?php echo $item->regio; ?></td>      
                    <td><?php echo $item->ort01; ?></td>      
                    <td><?php echo $item->pstlz; ?></td>      
                    <td><?php echo $item->ktokk; ?></td>
                    <td><?php echo $item->ekgrp; ?></td>
                    <td class="text-center">
                        <form>
                            <input type="hidden" name="supp_id" value="<?php echo "{$item->supp_id}";?>">
                            <button type="submit" name="action" value="setVendor" class="btn btn-primary">
                                <?php echo $item->lifnr; ?>
                            </button>
                        </form>
                    </td>    
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