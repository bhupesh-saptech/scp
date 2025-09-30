<?php    
    $conn = new Model\Conn();
    if(isset($_GET['pass_id'])) {
        $rqst = json_decode(json_encode($_GET));
        $query = "select a.*,
                         b.sdesc as vlog_ds,
                         b.ntask as vlog_ts,
                         c.user_nm  
                    from veh_logs as a 
                    left outer join veh_stat as b 
                      on b.cstat = a.vlog_st 
                    left outer join usr_data as c 
                      on c.user_id = a.user_id 
                   where a.pass_id = :pass_id
                    order by a.vlog_dt,a.vlog_tm";
        $param = array($rqst->pass_id);
        $items = $conn->execQuery($query,$param);
    }
?>
<div class="card ">
        <div class="card-header">
            <h4 class="card-title">Vehicle Pass Status Change History</h4>
            <button class="btn btn-danger float-right" onclick="window.close();">
                Close
            </button>
            <?php include('../incld/messages.php'); ?>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            
            <table id="list_pass" class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-primary">
                        <th style="width:10%">Sr.No</th>
                        <th style="width:10%">VehPass</th>
                        <th style="width:10%">Changed By</th>
                        <th style="width:10%">User Name</th>
                        <th style="width:10%">Change Date</th>
                        <th style="width:10%">Change Time</th>
                        <th style="width:10%">VP Status</th>
                        <th style="width:10%">Status Desc</th>
                        <th style="width:10%">Next Task</th>


                    </tr>
                </thead>
                <tbody>
            <?php 
                if(isset($items)) {
                    $count = 0;
                    foreach($items as $item) { 
                        $count = $count + 1;?>
                        <tr>
                            <td class="text-right"><?php echo "{$count}" ;?></td>
                            <td><a href="<?php echo "../api/scp_pass.php?pass_id={$item->pass_id}";?>" ><?php echo $item->pass_id; ?></a></td>
                            <td><?php echo $item->user_id;  ?></td>
                            <td><?php echo $item->user_nm;  ?></td>
                            <td class="text-right"><?php echo $item->vlog_dt;  ?></td>
                            <td class="text-right"><?php echo $item->vlog_tm;  ?></td>
                            <td><?php echo $item->vlog_st;  ?></td>
                            <td class="bg-success"><?php echo $item->vlog_ds;  ?></td>
                            <td class="bg-warning"><?php echo $item->vlog_ts;  ?></td>
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
            "pageLength": 20, "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#list_pass_wrapper .col-md-6:eq(0)');

        });
    </script>
<?php
    include('../incld/footer.php');
?>