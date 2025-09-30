<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/header.php';
    require '../suppl/top_menu.php';
    require '../suppl/side_menu.php';
    require '../incld/autoload.php';
    $cntr = new Contr\PassContr();
    $poit = new Contr\POItemContr();
    $vitm = new Contr\VehItemContr();
    if(isset($_POST['pass_id'])) {
        $pass_id = $_POST['pass_id'];
    } else {
        $pass_id = "";
    }
    $query = "select * from veh_pass where pass_id = ?";
    $param = array($pass_id);
    $pass = $cntr->readPass($query,$param)[0];
    if(isset($_POST['addItem'])) {
      $rqst = json_decode(json_encode($_POST));
      $purord = substr($rqst->poitem, 0, 10);
      $poitem = substr($rqst->poitem, 10);
      $query = "select * from data_poi where ebeln =? and ebelp = ? ";
      $param = array($purord,$poitem);
      $items = $poit->readPOItem($query,$param);
      $item  = $items[0];
    }
    if(isset($_POST['setItem'])) {
      $rqst = json_decode(json_encode($_POST));
      $query = "insert ignore 
                      into veh_item ( pass_id,
                                       chln_id,
                                       item_id,
                                       chln_no,
                                       chln_dt,
                                       cinv_no,
                                       cinv_dt,
                                       ebeln,
                                       ebelp,
                                       matnr,
                                       txz01,
                                       lifnr,
                                       lfimg,
                                       meins,
                                       wrbtr,
                                       zlrno,
                                       zlrdt )
                              values   (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $param = array( $rqst->pass_id,
                      $rqst->chln_id,
                      $rqst->item_id,
                      $rqst->chln_no,
                      $rqst->chln_dt,
                      $rqst->cinv_no,
                      $rqst->cinv_dt,
                      $rqst->ebeln,
                      $rqst->ebelp,
                      $rqst->matnr,
                      $rqst->txz01,
                      $rqst->lifnr,
                      $rqst->lfimg,
                      $rqst->meins,
                      $rqst->wrbtr,
                      $rqst->zlrno,
                      $rqst->zlrdt); 
      $vitm->createVehItem($query,$param);
      $query = "select * from veh_item where pass_id =? and chln_id = ? and item_id = ?";
      $param = array($rqst->pass_id,$rqst->chln_id,$rqst->item_id);
      $items = $poit->readPOItem($query,$param);
      $item  = $items[0];
      
    }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Vehicle Pass Invoices</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Pass Invoice</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
<?php
    include '../suppl/form_item.php';
    echo '</div>';
?>


<?php
    include '../incld/jslib.php'; 
?>
<?php
    include('../incld/footer.php');
?>