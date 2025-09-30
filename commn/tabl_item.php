<?php
    $rqst = json_decode(json_encode($_GET));
    
    $query = "select * from veh_data where pass_id = ?";
    $param = array($rqst->pass_id);
    $pass = $util->execQuery($query,$param,1);

    $query = "select * from veh_item where pass_id = ? ";
    $param = array($rqst->pass_id);
    $items = $util->execQuery($query,$param);
    if(!isset($items)) {
        $item->cstat = 'XX';
        $_SESSION['status'] = 'There are no invoices in this Vehicle';
    }
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
                    <th style="width:10%;">
                        <label for="">Vehicle Pass</label>
                        <input type="text" name="pass_id"  class="form-control"  value="<?php echo $pass->pass_id; ?>" disabled>       
                    </th>
                    <th style="width:10%;">
                        <label for="">Created On</label>
                        <input type="text" name="erdat"  class="form-control"  value="<?php echo $pass->erdat; ?>" disabled>       
                    </th>
                    <th style="width:10%;">
                        <label for="">Created Time</label>
                        <input type="text" name="erzet"  class="form-control"  value="<?php echo $pass->erzet; ?>" disabled>       
                    </th>
                    <th style="width:10%;">
                        <label for="">Vehicle Number</label>
                        <input type="text" name="zvehno"   class="form-control"  value="<?php echo $pass->zvehn;   ?>" disabled>
                    </th>
                    <th style="width:10%;">
                        <label for="">Transporter</label>
                        <input type="text" name="ztnam"   class="form-control"  value="<?php echo $pass->ztnam;   ?>" disabled>
                    </th>
                    <th style="width:10%;">
                        <label for="">Driver Name</label>
                        <input type="text" name="zdnam"   class="form-control"  value="<?php echo $pass->zdnam;   ?>" disabled>
                    </th>
                   <th style="width:10%;">
                        <label for="">Contact No</label>
                        <input type="text" name="zmbno"   class="form-control"  value="<?php echo $pass->zmbno;   ?>" disabled>
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
                    <th style="width:06%">Tag</th>
                    <th style="width:12%">Chln Item</th>
                    <th style="width:12%">PO Item</th>
                    <th style="width:18%">Material</th>
                    <th style="width:06%">Plant</th>
                    <th style="width:06%">StLoc</th>
                    <th style="width:08%">Batch</th>
                    <th style="width:08%">CH Bags</th>
                    <th style="width:08%">PP Bags</th>
                    <th style="width:08%">JT Bags</th>
                    <th style="width:08%">RJ Bags</th>
                    
                </tr>
            </thead>
            <tbody>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { 
                    $item->matnr = ltrim($item->matnr,'0');
        ?>
                    <tr>
                        <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../commn/print_pass.php?objky='.$item->objky;?>');"><i class="fa fa-file-pdf"></i></a></td>
                        <td><a href="../commn/disp_item.php?objky=<?php echo "{$item->objky}";?>"><?php echo "{$item->objky}";?></a></td>
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