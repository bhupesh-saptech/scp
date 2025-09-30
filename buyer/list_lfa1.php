<?php 
    include('../incld/verify.php');
    include('../incld/header.php');
    include('../buyer/top_menu.php');
    include('../buyer/side_menu.php');
    include('../incld/dbconn.php');
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $dtset = $conn->query("select a.* from sup_mast as a inner join prgroup as b on b.ekgrp = a.ekgrp where b.user_id = '$user->user_id'");
        $items = json_decode(json_encode($dtset->fetch_all(MYSQLI_ASSOC)));
        $conn->close();
    }

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vendor Master</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vendor Master</li>
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
            <th>Vendor </th>    
            <th>Vendor Name</th>
            <th>Country</th>
            <th>Region</th>
            <th>City</th>
            <th>Pin Code</th>
            <th>Type</th>
            <th>Pur.Group</th>
            <th>UserID</th>
        </tr>
    </thead>
    <?php 
            foreach($items as $item ) { 
                $item->lifnr = ltrim($item->lifnr,'0');
    ?>
             <tr>
                 <td><?php echo $item->lifnr;   ?></td>
                 <td><?php echo $item->name1;   ?></td>
                 <td><?php echo $item->land1;   ?></td>
                 <td><?php echo $item->regio;   ?></td>
                 <td><?php echo $item->ort01;   ?></td>
                 <td><?php echo $item->pstlz;   ?></td>
                 <td><?php echo $item->ktokk;   ?></td>
                 <td><?php echo $item->ekgrp;   ?></td>
                 <td><?php echo $item->user_id; ?></td>
             </tr>
    <?php 
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