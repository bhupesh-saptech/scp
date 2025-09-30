<?php
    $conn = new Model\Util();
    $sess = json_decode(json_encode($_SESSION));
    $query = "select * from veh_data where werks = ? 
                order by pass_id desc limit 10";
    $param = array($sess->plnt_id);
    $items = $conn->execQuery($query,$param);
    $_SESSION['pref_id'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
?>
<div class="card ">
    <div class="card-header">
        <?php include('../incld/messages.php'); ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="list_pass" class="table table-bordered table-striped">
        <thead>
            <tr class="bg-primary">
                <th style="width:02%">Q</th>
                <th style="width:10%">VehPass</th>
                <th style="width:10%">ArriveDt </th>
                <th style="width:10%">ArriveTm</th>
                <th style="width:10%">Vehicle No</th>
                <th style="width:25%">Material</th>
                <th style="width:10%">Quantity</th>
                <th style="width:05%">UoM</th>
                <th style="width:14%">Status</th>
                <th style="width:04%">Log</th>
            </tr>
        </thead>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { 
                    $query = "select * from veh_item where pass_id = ?";
                    $param = array($item->pass_id);
                    $matn  = $util->execQuery($query,$param,1);
                    if(!isset($matn)) {
                        $matn = new stdClass();
                        $matn->matnr = "";
                        $matn->txz01 = "";
                        $matn->lfimg = "";
                        $matn->vrkme = "";
                    } else {
                        $matn->matnr = ltrim($matn->matnr,'0');
                        $matn->txz01 = substr($matn->txz01,0,20);
                    }
                    $query = "select * from veh_logs where pass_id = ? and vlog_st = 'VA' ";
                    $param = $param = array($item->pass_id);
                    $vlog  = $util->execQuery($query,$param,1);
                    if(!isset($vlog)) {
                        $vlog = new stdClass();
                        $vlog->vlog_dt = "";
                        $vlog->vlog_tm = "";
                    }
        ?>
                    <tr>
                        <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../api/scp_pass.php?pass_id='.$item->pass_id;?>');"><i class="fas fa-qrcode"></i></a></td>
                        <td><a href="javascript:void(0);" onclick="newTab('<?php echo '../commn/list_item.php?pass_id='.$item->pass_id;?>');"><?php echo $item->pass_id; ?></a></td>
                        <td><?php echo $vlog->vlog_dt;  ?></td>
                        <td><?php echo $vlog->vlog_tm;  ?></td>
                        <td><?php echo $item->zvehn; ?></td>
                        <td><?php echo "{$matn->matnr}_{$matn->txz01}";  ?></td>
                        <td class="text-right"><?php echo "{$matn->lfimg}";?></td>
                        <td><?php echo "{$matn->vrkme}";?></td>  
                        <td class="<?php echo "{$item->cscol}"?>"><?php echo $item->sdesc;  ?></td>
                        <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../commn/list_vlog.php?pass_id='.$item->pass_id;?>');"><i class="fa fa-history"></i></a></td>
                    </tr>
        <?php   }
            } 
        ?>
        </table>
    </div>
</div>

<?php
    include('../incld/jslib.php'); ?>
    <script>
        $(function () {
            $("#list_pass").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#list_pass_wrapper .col-md-6:eq(0)');

        });
        function newTab(url) {
            window.open(url,'_blank');
        }
    </script>
<?php
    include('../incld/footer.php');
?>