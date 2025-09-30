<?php
    include('../incld/verify.php');
    include('../suppl/check_auth.php');
    include('../incld/header.php');
    include('../suppl/top_menu.php');
    include('../suppl/side_menu.php');
    require '../incld/autoload.php';
    $conn = new Model\Conn();

    $rqst = new stdClass();
    $rqst->supp_id = $_SESSION['supp_id'];         
    $query = "select a.*,
                     b.chln_no,
                     b.chln_dt
               from veh_item as a 
               inner join veh_chln as b 
                  on b.pass_id = a.pass_id 
                 and b.chln_id = a.chln_id
                where b.supp_id = :supp_id 
                order by a.pass_id desc,a.chln_id,a.item_id";
    $param = array(':supp_id' =>$rqst->supp_id);
    $items = $conn->execQuery($query,$param);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vehicle Gate Pass</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">GatePass</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div><!-- /.col-md-col12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    <div class="card ">
        <div class="card-header">
            <?php include('../incld/messages.php'); ?>
        </div>
        <div class="row bg-dark">
            <div class="col-md-12">
               
            </div> 
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-primary">
                        <th>Pass ID</th>
                        <th>Challan No</th>
                        <th>Challan Dt</th>
                        <th>PO Num</th>
                        <th>Material</th>
                        <th>Plant</th>
                        <th>Delivery Qty</th>
                        <th>IBD Number</th>
                        <th>IBD Item</th>
                        
                    </tr>
                </thead>
                <tbody>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) { 
                        $item->matnr = ltrim($item->matnr,'0');
            ?>
                        <tr>
                            <td><?php echo "{$item->pass_id}" ;  ?></td>
                            <td><?php echo "{$item->chln_no}" ;  ?></td>
                            <td><?php echo "{$item->chln_dt}";  ?></td>
                            <td><?php echo "{$item->ebeln}_{$item->ebelp}";  ?></td>
                            <td><?php echo "{$item->matnr}_{$item->txz01}";  ?></td>
                            <td><?php echo "{$item->werks}"   ;  ?></td>
                            <td class="text-right"><?php echo "{$item->lfimg}"   ;  ?></td>
                            <td><?php echo "{$item->vgbel}"   ;  ?></td>
                            <td><?php echo "{$item->vgpos}"   ;  ?></td>
                        </tr>
            <?php   }
                } 
            ?>
                </tbody> 
            </table>
        </div>
    </div>
</div>

<?php
    include('../incld/jslib.php');
?>
<script>
    function newTab(url) {
        window.open(url,'_blank');
    }
</script>
<?php
    include('../incld/footer.php');
?>