<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/header.php';
    require '../suppl/top_menu.php';
    require '../suppl/side_menu.php';
    require '../suppl/dashboard.php';
    require '../incld/autoload.php';
    

    $conn = new Model\Conn();
    $util = new Model\Util();
    if(isset($_POST['filter']) && $_POST['filter'] == "filter" ) {
        $rqst = json_decode(json_encode($_POST));
        $sess->pstatus = $rqst->pstatus;
    } else {
        $sess->pstatus = "";
    }
    if(isset($_GET['pstatus'])) {
        $_SESSION['pstatus'] = $_GET['pstatus'];
    } else {
        $_SESSION['pstatus'] = "";
    }
    $sess = json_decode(json_encode($_SESSION));
    $query = "select * 
                from veh_stat";
    $param = array();
    $stats = $conn->execQuery($query,$param);
    
    $query =  " select *
                from veh_data 
               where erdat between ? and ?
                and cstat = COALESCE(NULLIF(?,''), cstat)
                and lifnr = ? 
                union
                select *
                  from veh_data
                 where pass_id  in ( select pass_id 
                                       from veh_supp 
                                      where erdat between ? and ? 
                                        and cstat = COALESCE(NULLIF(?,''), cstat) 
                                        and supp_id = ? )
                 order by pass_id desc";
    $util->writeLog(json_encode($sess));    
    $param = array( $sess->from_dt,
                    $sess->upto_dt,
                    $sess->pstatus,
                    $sess->supp_id,
                    $sess->from_dt,
                    $sess->upto_dt,
                    $sess->pstatus,
                    $sess->supp_id);

    $items = $conn->execQuery($query,$param);
?>


<div class="card ">
    <div class="card-header">
        <?php include('../incld/messages.php'); ?>
    </div>
    <div class="row bg-dark">
        <div class="col-md-12">
            <form method="post"> 
                <table class="table table-bordered table-stripped">
                    <tr >
                        <td class="col-md-8">
                            <h3> VGP - Vehicle Gate Pass Filter </h3>  
                        </td>
                        <td class="col-md-1">
                            <label for="" class="form-label mt-2">Pass Status</label>
                        </td>
                        <td class="col-md-3">
                            <div class="input-group mb-3">
                                <select name="pstatus" class="form-control" >
                                    <option value=""  >Select Status</option>
                                <?php foreach($stats as $stat) { ?>
                                    <option value="<?php echo "{$stat->cstat}"; ?>" <?php if($sess->pstatus == $stat->cstat ) { echo "selected"; }  ?> ><?php echo "{$stat->sdesc}"; ?></option>
                                <?php } ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="filter" value="filter">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div> 
    </div>
    <!-- /.card-header -->

    <div class="card-body">
            <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:03%">QR</th>
                    <th style="width:08%">VGP Num</th>
                    <th style="width:08%">VGP Date </th>
                    <th style="width:08%">Vehicle No</th>
                    <th style="width:10%">Transporter</th>
                    <th style="width:10%">Loading Location</th>
                    <th style="width:10%">Driver Name</th>
                    <th style="width:08%">Mobile</th>
                    <th style="width:08%">SGP Num</th>
                    <th style="width:15%">Status</th>
                </tr>
            </thead>
            <tbody>
        <?php 
            if(isset($items)) {
                foreach($items as $item) { ?>
                    <tr>
                        <td><a href="javascript:void(0);" onclick="newTab('<?php echo '../api/scp_qrcd.php?pass_id='.$item->pass_id;?>');"><i class="fas fa-qrcode"></i></a></td>
                        <td><a href="javascript:void(0);" onclick="newTab('<?php echo 'form_pass.php?pass_id='.$item->pass_id;?>');"><?php echo $item->pass_id; ?></a></td>
                        <td><?php echo $item->erdat;  ?></td>
                        <td><?php echo $item->zvehn;  ?></td>
                        <td><?php echo $item->ztnam;  ?></td>
                        <td><?php echo $item->zzloc;  ?></td>
                        <td><?php echo $item->zdnam;  ?></td>
                        <td><?php echo $item->zmbno;  ?></td>
                        <td><?php echo $item->zvpno;  ?></td>
                        <td><?php echo $item->cstat .' : '.$item->sdesc;  ?></td>
                    </tr>
        <?php   }
            } 
        ?>
            </tbody> 
        </table>
    </div>
</div>

<?php
    require '../incld/jslib.php';
?>
<script>
    function newTab(url) {
        window.open(url,'_blank');
    }
</script>
<?php
    require '../incld/footer.php';
?>