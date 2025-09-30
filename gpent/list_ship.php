<?php 
    include('../incld/verify.php');
    include('../gpent/check_auth.php');
    include('../incld/header.php');
    include('../incld/top_menu.php');
    include('../gpent/side_menu.php');
    include('../incld/dbconn.php');
    $dtset = $conn->query("select * from data_shp ");
    $items = json_decode(json_encode($dtset->fetch_all(MYSQLI_ASSOC)));
    $conn->close();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Stores Department - Shipments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shipments</li>
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
            <th>Shipment</th>
            <th>Ship Date</th>
            <th>Vehicle</th>
            <th>Trans code</th>
            <th>Driver Name</th>
            <th>Contact No</th>
            <th>License</th>
            <th>Status</th>
        </tr>
    </thead>
    <?php 
        if(isset($items)) {
            foreach($items as $item) {
                $item->lifnr = ltrim($item->lifnr,'0');
    ?>
            <tr>
                 <td><?php echo $item->lifnr; ?></td>
                 <td><?php echo $item->tknum; ?></td>
                 <td><?php echo $item->erdat; ?></td>
                 <td><?php echo $item->signi; ?></td>
                 <td><?php echo $item->tdlnr; ?></td> 
                 <td><?php echo $item->exti1; ?></td>          
                 <td><?php echo $item->exti2; ?></td>          
                 <td><?php echo $item->tpbez; ?></td>          
                 <td><?php echo $item->sttrg; ?></td>
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