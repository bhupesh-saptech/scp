<?php
    require '../incld/verify.php';
    require '../stloc/check_auth.php';
    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../stloc/side_menu.php'; 
    require '../stloc/dashboard.php';
    require '../incld/autoload.php';

    $rqst = json_decode(json_encode($_GET));
    
    $query = "select * from veh_data where pass_id = ?";
    $param = array($rqst->pass_id);
    $pass = $util->execQuery($query,$param,1);

    $query = "select * from veh_item where pass_id = ? order by netpr ";
    $param = array($rqst->pass_id);
    $items = $util->execQuery($query,$param);
    $_SESSION['pref_id'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<div class="card ">
    <div class="card-header">
        <h4 class="card-title">Veh Pass Item Details</h4>
        <button type="button" class="btn btn-danger float-right" onclick="window.close();">Close</button>
        <?php include('../incld/messages.php'); ?>
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
        <table id="items" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Chln Item</th>
                    <th>PO Item</th>
                    <th>Material</th>
                    <th>Plant</th>
                    <th>StLoc</th>
                    <th>Batch</th>
                    <th>CH Bags</th>
                    <th>PP Bags</th>
                    <th>JT Bags</th>
                    <th>RJ Bags</th>
                    
                </tr>
            </thead>
            <tbody>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { 
                    $item->matnr = ltrim($item->matnr,'0');
        ?>
                    <tr>
                        <td><a href="disp_item.php?objky=<?php echo "{$item->objky}";?>"><?php echo "{$item->objky}";?></a></td>
                        <td><?php echo "{$item->ebeln}_{$item->ebelp}";  ?></td>
                        <td><?php echo "{$item->matnr}_{$item->txz01}";  ?></td>               </td>
                        <td><?php echo "{$item->werks}"   ;  ?></td>
                        <td><?php echo "{$item->lgort}"   ;  ?></td>
                        <td><?php echo "{$item->charg}"   ;  ?></td> 
                        <td class="text-right"><?php echo "{$item->zchbg}"   ;  ?></td>
                        <td class="text-right"><?php echo "{$item->zppbg}"   ;  ?></td>
                        <td class="text-right"><?php echo "{$item->zjtbg}"   ;  ?></td>
                        <td class="text-right"><?php echo "{$item->zrjbg}"   ;  ?></td>                        
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
     $(function () {
            $("#items").DataTable({
            "ordering": false,
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#items_wrapper .col-md-6:eq(0)');

    });
    function updtBags(obj) {
        debugger;
        row = $(obj).closest('tr');
        zchbg = row.find("input[name='zchbg']").val();
        zppbg = row.find("input[name='zppbg']").val();
        zjtbg = row.find("input[name='zjtbg']").val();
        zntbg = Number(zppbg) + Number(zjtbg);
        zrjbg = Number(zchbg) - Number(zntbg);
        row.find("input[name='zrjbg']").val(zrjbg);
    }
    function newTab(url) {
        window.open(url,'_blank');
    }
</script>
<?php
    include('../incld/footer.php');
?>