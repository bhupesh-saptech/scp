<?php
    $sess = json_decode(json_encode($_SESSION));
    $util = new Model\Util();
    $query = "select * from veh_data where lifnr = ? 
              union
              select * from veh_data where pass_id in (select pass_id from veh_supp where supp_id = ?)
              order by pass_id desc limit 10";
    $param = array($sess->supp_id,$sess->supp_id);
    $items = $util->execQuery($query,$param);
?>
<div class="card ">
        <div class="card-header">
        <a href="javascript:void(0);" class="btn btn-primary float-right" onclick="newTab('<?php echo 'disp_pass.php';?>');">Add Vehicle Pass</a>
            <?php include('../incld/messages.php'); ?>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            
            <table id="list_pass" class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-primary">
                        <th style="width:05%">QR</th>
                        <th style="width:08%">VGP Num</th>
                        <th style="width:08%">VGP Date </th>
                        <th style="width:08%">Vehicle No</th>
                        <th style="width:12%">Transporter</th>
                        <th style="width:12%">Driver Name</th>
                        <th style="width:08%">Mobile</th>
                        <th style="width:08%">GatePass</th>
                        <th style="width:10%">Status</th>
                        <th style="width:05%">Items</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) { ?>
                        <tr>
                            <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../api/scp_qrcd.php?pass_id='.$item->pass_id;?>');"><i class="fas fa-qrcode"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="newTab('<?php echo 'disp_pass.php?pass_id='.$item->pass_id;?>');"><?php echo $item->pass_id; ?></a></td>
                            <td><?php echo $item->erdat;  ?></td>
                            <td><?php echo $item->zvehn;  ?></td>
                            <td><?php echo $item->ztnam;  ?></td>
                            <td><?php echo $item->zdnam;  ?></td>
                            <td><?php echo $item->zmbno;  ?></td>
                            <td><?php echo $item->zvpno;  ?></td>
                            <td class="bg-info"><?php echo $item->sdesc;  ?></td>
                            <td class="text-center"><a class="btn btn-primary" href="<?php echo "disp_chln.php?pass_id={$item->pass_id}"; ?>"><i class="fa fa-search" style="font-size:0.6rem;"></a></i></td>
                            
                        </tr>
            <?php   }
                } 
            ?>
                </tbody> 
            </table>
        </div>
    </div>
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