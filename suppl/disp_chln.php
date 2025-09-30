<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/autoload.php';
    $conn = new Model\Conn();
    $util = new Model\Util();
    // if(isset($_GET['chkInv'])) {
    //   $rqst = json_decode(json_encode($_GET));
    //   $query = "select count(*) as count from veh_chln where supp_id = ?
    //                                            and chln_no = ?
    //                                            and chln_yr = ?";
    //   $param = array($rqst->supp_id,$rqst->chln_no,$rqst->chln_yr);
    //   $item  = $util->execQuery($query,$param,1);
    //   echo (json_encode($item));
    //   die();
    // }
    if(isset($_GET['getData'])) {
      $rqst = json_decode(json_encode($_GET));
      $query = "select * from zpoi_view where ebeln = ? and ebelp = ?";
      $param = array($rqst->ebeln,$rqst->ebelp);
      $item  = $conn->execQuery($query,$param,1);
      $query = "select * from zpoc where ebeln = ? and ebelp = ? and kschl in ('ZBR1','ZBR2','ZBR3')";
      $param = array($rqst->ebeln,$rqst->ebelp);
      $cond  = $conn->execQuery($query,$param,1);
      $item->ntmng = ( $item->menge * ( ($item->uebto / 100 ) + 1 ) ) - $item->wemng - $item->chqty;
      if(!is_null($cond)) {
        $item->brokr = $cond->lifnr;
        $item->bname = $cond->name1;
      } else {
        $item->brokr = "";
        $item->bname = "";
      }
      echo json_encode($item);
      die();
    }
    require '../incld/header.php';
    require '../suppl/top_menu.php';
    require '../suppl/side_menu.php';
    
    $cntr = new Contr\VehPassContr();
    $poit = new Contr\POItemContr();
    $conn = new Model\Conn();

    if(isset($_POST['action'])) {
      $rqst = json_decode(json_encode($_POST));
      $actn = $rqst->action;
      switch($rqst->action) {
        case  'newChln' :
          $rqst = json_decode(json_encode($_POST));
          $query = "select count(*) as count from veh_chln where supp_id = ?
                                               and chln_no = ?
                                               and chln_yr = ?";
          $param = array($rqst->supp_id,$rqst->chln_no,$rqst->chln_yr);
          $item  = $util->execQuery($query,$param,1);
          if($item->count > 0 ) {
            echo "<script>alert('Duplicate Invoice - Please check');</script>";
            $_SESSION['status'] = 'Duplicate Invoice - Please check';
          } else {
            $cntr = new Contr\VehChlnContr();
            $cntr->createVehChln($rqst);
            $cntr = new Contr\VehItemContr();
            $cntr->createVehItem($rqst);
            $cntr = new Contr\VehPassContr();
            $cntr->createVehSupp($rqst);
            $_SESSION['status'] = "Challan {$rqst->chln_no}_{$rqst->chln_dt} created";
          }
          break;
        case  'newItem' :
          $cntr = new Contr\VehItemContr();
          $cntr->createVehItem($rqst);
          $_SESSION['status'] = "Challan Item created {$rqst->ebeln}_{$rqst->ebelp} : {$rqst->matnr}_{$rqst->txz01}";
          break;
        case  'modChln' :
          $cntr = new Contr\VehChlnContr();
          $cntr->modifyVehChln($rqst);
          $_SESSION['status'] = "Challan {$rqst->chln_no}_{$rqst->chln_dt} modified";;
          break;
        case  'modItem' :
          $cntr = new Contr\VehItemContr();
          $cntr->modifyVehItem($rqst);
          $_SESSION['status'] = "Challan Item modified {$rqst->ebeln}_{$rqst->ebelp} : {$rqst->matnr}_{$rqst->txz01}";
          break;
        case  'delChln' :
          $cntr = new Contr\VehChlnContr();
          $cntr->deleteVehChln($rqst);
          $_SESSION['status'] = "Challan {$rqst->chln_no}_{$rqst->chln_dt} deleted";
          break;
        case  'delItem' :
          $cntr = new Contr\VehItemContr();
          $cntr->deleteVehItem($rqst);
          $_SESSION['status'] = "Challan Item  {$rqst->ebeln}_{$rqst->ebelp} : {$rqst->matnr}_{$rqst->txz01} deleted";
          break;
        default :
          $actn = $_POST['action'];
          break;
      }
    } else {
      $actn = "noAction";
    }
    
    
    if(isset($_GET['pass_id'])) {
      $pass_id = $_GET['pass_id'];
    } else {
        $pass_id = "";
    }
    $query = "select * from veh_data where pass_id = ?";
    $param = array($pass_id);
    $pass = $conn->execQuery($query,$param,1);


    $query = "select * from veh_chln where pass_id = ? 
                                       and supp_id = ?";
    $param = array($pass_id,$_SESSION['supp_id']);
    $chlns = $conn->execQuery($query,$param);

    // $util->writeLog(json_encode($chlns));

   
    $query = "select * from zpoi_view where lifnr =? and werks = ? and ntmng > 0 and eindt >= curdate() ";
    $param = array($_SESSION['supp_id'],$pass->werks);
    $pitem = $conn->execQuery($query,$param);
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">VP - Challan Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">VP-Challans</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content-header -->

<?php
    include '../suppl/form_chln.php';
?>

<?php
    include '../incld/jslib.php'; 
?>
<script>
  $( document ).ready(function() {
    $('.select2').select2();
  });
  function chkChlnForm(obj, event) {
    //  // ✅ Immediately stop the default submission

    let form = $(obj);
    let lfimg = form.find('input[name="lfimg"]').val();
    let ntmng = form.find('input[name="ntmng"]').val();

    if (Number(lfimg) > Number(ntmng)) {
      alert('Challan Qty Cannot be More Than PO Qty');
      event.preventDefault();
    }
  }
  function chkItemForm(obj,event) {
      debugger;
      let form = $(obj);
      var lfimg = form.find('input[name="lfimg"]').val();
      var ntmng = form.find('input[name="ntmng"]').val();
      if(Number(lfimg) > Number(ntmng)) {
        alert('Challan Qty Can not be More Than PO Qty');
        event.preventDefault();
      }
    }

    function modChlnForm(obj) {

      if (obj.type === "button") {
        row = $(obj).closest('tr'); 
        row.find("select").prop('disabled', false);
        row.find("input").attr('readonly', false);
        obj.innerHTML = '<i class="fa fa-save"></i>';
        obj.type = "submit"; // ✅ Change to submit
        event.preventDefault();
      } 

    }
    function modItemForm(obj) {

      if (obj.type === "button") {
        row = $(obj).closest('tr'); 
        row.find('select[name="pitem"').prop('disabled', false);
        row.find('select[name="zpmat"').prop('disabled', false);
        row.find('input[name="lfimg"').attr('readonly', false);
        row.find('input[name="zchbg"').attr('readonly', false);
        obj.innerHTML = '<i class="fa fa-save"></i>';
        obj.type = "submit"; // ✅ Change to submit
        event.preventDefault();
      } 

    }
	  function calcAmt(obj)  {
      let crow = $(obj).closest('tr');
      let rate = crow.find('input[name="netpr"]').val();
      let cqty = crow.find('input[name="lfimg"]').val();
      crow.find('input[name="netwr"]').val(rate * cqty);
    }
  
    function getPOItem(obj) {
      debugger;
      let ebeln = $(obj).val().substr(0,10);
      let ebelp = $(obj).val().substr(11,2);
      let rowno = $(obj).closest('tr');
      $.get(window.location.href, { ebeln: ebeln, ebelp: ebelp,getData: true }, function(data) {
        try {
              console.log(data);
              var oData = JSON.parse(data);
              rowno.find('input[name="ebeln"]').val(oData.ebeln);
              rowno.find('input[name="ebelp"]').val(oData.ebelp);
              rowno.find('input[name="brokr"]').val(oData.brokr);
              rowno.find('input[name="bname"]').val(oData.name1);
              rowno.find('input[name="broker"]').val(oData.brokr + '_' + oData.bname);
              rowno.find('input[name="matnr"]').val(oData.matnr);
              rowno.find('input[name="txz01"]').val(oData.txz01);
              rowno.find('input[name="mdesc"]').val(oData.matnr.replace(/^0+/, "") + '_' +oData.txz01);
              rowno.find('input[name="werks"]').val(oData.werks);
              rowno.find('input[name="lgort"]').val(oData.lgort);
              rowno.find('input[name="bsart"]').val(oData.bsart);
              rowno.find('input[name="eindt"]').val(oData.eindt);
              rowno.find('input[name="uebto"]').val(oData.uebto);
              rowno.find('input[name="ntmng"]').val(oData.ntmng);
              rowno.find('input[name="shmng"]').val(oData.ntmng);
              rowno.find('input[name="netpr"]').val(oData.netpr);
              rowno.find('input[name="peinh"]').val(oData.peinh);
              rowno.find('input[name="vrkme"]').val(oData.meins);
              rowno.find('input[name="xchar"]').val(oData.xchar);
            } catch (e) {
              console.error("Invalid JSON response", e);
            }
      });
    }

    function updtChallan(obj) {
      debugger;
      let row = $(obj).closest('tr');
      row.find("input[name='chln_no']").val($(obj).val());
    }
    function updtChlnDt(obj) {
      debugger;
      let row = $(obj).closest('tr');
      row.find("input[name='chln_dt']").val($(obj).val());
      let date = new Date($(obj).val());
      let year = date.getFullYear();
      let month = date.getMonth() + 1; // Months are 0-based (0 = January)
      if (month < 4) {
          FY = (year - 1);
      } else {
          FY = year;
      }
			row.find('input[name="chln_yr"]').val(FY);
			row.find('input[name="cinv_yr"]').val(FY);
    }  
    function preventEnter(e) {
      if (e.key === "Enter") {
        e.preventDefault(); // Prevent form submission
        return false;
      }
    }
 </script>
<?php
    include('../incld/footer.php');
?>