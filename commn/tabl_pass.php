<?php    
    $conn = new Model\Conn();
    if(isset($_GET['pstatus'])) {
        $_SESSION['pstatus'] = $_GET['pstatus'];
    } else {
        $_SESSION['pstatus'] = "";
    }
    $sess = json_decode(json_encode($_SESSION));
    $query = "select * from veh_data where cstat = ? and erdat between ? and ? and werks = ? order by pass_id desc";
    $param = array($sess->pstatus,
                   $sess->from_dt,
                   $sess->upto_dt,
                   $sess->plnt_id);
    $items = $conn->execQuery($query,$param);
    $_SESSION['pref_id'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
?>
<div class="card">
    <div class="card-header">
        <?php include('../incld/messages.php'); ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body"> 
        <table id="list_pass" class="table table-bordered table-striped">
            <thead>
                <tr class="bg-primary">
                    <th style="width:05%">QR</th>
                    <th style="width:10%">VehPass</th>
                    <th style="width:10%">Vehicle No</th>
                    <th style="width:14%">Transporter</th>
                    <th style="width:14%">Driver Name</th>
                    <th style="width:10%">Mobile</th>
                    <th style="width:10%">Shipment</th>
                    <th style="width:14%">Curr.Status</th>
                    <th style="width:10%">Nxt Action</th>
                    <th style="width:05%">Log</th>
                </tr>
            </thead>
            <tbody>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { ?>
                    <tr>
                        <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../api/scp_pass.php?pass_id='.$item->pass_id;?>');"><i class="fas fa-qrcode"></i></a></td>
                        <td><a href="javascript:void(0);" onclick="newTab('<?php echo '../commn/list_item.php?pass_id='.$item->pass_id;?>');"><?php echo $item->pass_id; ?></a></td>
                        <td><?php echo $item->zvehn; ?></td>
                        <td><?php echo $item->ztnam;  ?></td>
                        <td><?php echo $item->zdnam;  ?></td>
                        <td><?php echo $item->zmbno;  ?></td>
                        <td><?php echo $item->tknum;  ?></td>
                        <td class="bg-success"><?php echo $item->sdesc;  ?></td>
                        <td class="bg-warning"><?php echo $item->ntask;  ?></td>
                        <td class="text-center"><a href="javascript:void(0);" onclick="newTab('<?php echo '../commn/list_vlog.php?pass_id='.$item->pass_id;?>');"><i class="fa fa-history"></i></a></td>
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
        $("#list_pass").DataTable({
        "pageLength": 20,"responsive": true, "lengthChange": false, "autoWidth": false,
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