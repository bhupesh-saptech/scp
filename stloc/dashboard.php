<?php     
    require '../incld/autoload.php';
    $dash  = new stdClass;
    $dash->cnt1 = 0;
    $dash->cnt2 = 0;
    $dash->cnt3 = 0;
    $dash->cnt4 = 0;
    $dash->cnt5 = 0;
    $dash->cnt6 = 0;
    $cntr  = new Contr\VehPassContr();
    $util  = new Model\Util();  
    $query = "select cstat        as cstat,
                     max(sdesc)   as sdesc,
                     max(idesc)   as idesc,
                     count(cstat) as count
                from veh_data 
               where erdat between ? and ?
                 and werks = ?
               group by cstat";
    $param = array($sess->from_dt,$sess->upto_dt,$sess->plnt_id);
    $items = $cntr->readCount($query,$param);
    if(!is_null($items)) {
      foreach($items as $item) {
        switch($item->cstat) {
            case 'QA' : $dash->cnt1 = $item->count;break;
            case 'SL' : $dash->cnt2 = $item->count;break;
            case 'CI' : $dash->cnt3 = $item->count;break;
            case 'GW' : $dash->cnt4 = $item->count;break;
            case 'UL' : $dash->cnt5 = $item->count;break;
            case 'GR' : $dash->cnt6 = $item->count;break;
        }
      }
    }

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Unloading Loc Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Unloading Loc</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?php echo $dash->cnt1; ?></h3>

                <p>For StLoc Updation</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=QA" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo $dash->cnt2; ?></h3>

                <p>For StLoc Updated</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=SL" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-warning ">
              <div class="inner">
                <h3><?php echo $dash->cnt3; ?></h3>
                <p>Vehicles Checked-IN</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=CI" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success ">
              <div class="inner">
                <h3><?php echo $dash->cnt4; ?></h3>

                <p>For Unloading</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=GW" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dash->cnt5; ?></h3>

                <p>Vehicle Unloaded</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=UL" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $dash->cnt6; ?></h3>
                <p>GR-105 Done</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="../commn/list_pass.php?pstatus=GR" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>