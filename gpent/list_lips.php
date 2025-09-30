<?php 
    require '../incld/verify.php';
    require '../gpent/check_auth.php';
    require '../incld/header.php';
    require '../incld/top_menu.php';
    require '../gpent/side_menu.php';
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
    $query = "select * from zibd where vgbel = COALESCE(NULLIF(@vgbel, ''), :ebeln) and vgpos = COALESCE(NULLIF(@vgpos, ''), :ebelp) and lifnr = :lifnr and budat between :start_dt and :upto_dt";
    $param = array($rqst->ebeln,$rqst->ebelp,$sess->supp_id,$sess->from_dt,$sess->upto_dt);
    $items = $conn->execQuery($query,$param);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Stores Department - Inbound Deliveries</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">IB Delivery</li>
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

    <div class="card">
        <div class="card-header">
        </div>
        <!-- /.card-header -->
        <div class="card-body">
    <table id="dtbl" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Vendor</th>
            <th>Delivery</th>
            <th>Del Item</th>
            <th>Del Date</th>
            <th>Material</th>
            <th>Description</th>
            <th>Plant</th>
            <th>StLoc</th>
            <th>Del Qty</th>
            <th>UoM</th>
        </tr>
    </thead>
    <?php 
        if(isset($items)) {
            foreach($items as $item) {
                $item->lifnr = ltrim($item->lifnr,'0');
    ?>
            <tr>
                 <td><?php echo $item->lifnr; ?></td>
                 <td><?php echo $item->vbeln; ?></td>
                 <td><?php echo $item->posnr; ?></td>
                 <td><?php echo $item->erdat; ?></td>          
                 <td><?php echo $item->matnr; ?></td>          
                 <td><?php echo $item->arktx; ?></td>          
                 <td><?php echo $item->werks; ?></td>          
                 <td><?php echo $item->lgort; ?></td>
                 <td><?php echo $item->lfimg; ?></td>
                 <td><?php echo $item->vrkme; ?></td>
             </tr>
    <?php 
            } 
        }
    ?>
</table>
</div>
    </div>
</div>

<?php
    include('../incld/jslib.php');
    include('../incld/footer.php');
?>