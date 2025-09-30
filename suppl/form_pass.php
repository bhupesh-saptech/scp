
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vehicle Pass </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Pass</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    <div class="card">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="card-header">
                    <?php include('../incld/messages.php'); ?>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
        <div class="card-body">
           
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                    <table class="table table-bordered table-stripped">
                        <tr class="bg-info">
                            <form method="POST" >
                            <td>
                                <label for="">Search Vehicle</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="vehno"    value="" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit" name="action" value="getVehicle">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            </form>
                            <form method="POST" autocomplete="off">
                            <td class="col-sm-3">
                                <label for="">Vehicle No</label>
                                <input type="text" name="zvehn" class="form-control" value="<?php echo $pass->zvehn;?>" required  >
                            </td>
                            <td class="col-sm-3">
                                <label for="">Pass Number</label>
                                <input type="text"   name="pass_id" class="form-control"  value="<?php echo $pass->pass_id; ?>" required  >      
                            </td>
                                                        <td class="col-sm-3">
                                <label for="">Pass Status</label>
                                <input type="text"   name="cstat" class="form-control"  value="<?php echo "{$pass->cstat} : {$pass->sdesc}"; ?>" required  >   
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <th class="col-md-6">
                                <input type="hidden" name="pass_id" class="form-control"  value="<?php echo $pass->pass_id; ?>"   >
                                <input type="hidden" name="action"  class="form-control"  value="<?php echo $action;  ?>" id="action">
                                <input type="hidden" name="user_id" class="form-control"  value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="lifnr"   class="form-control"  value="<?php echo $_SESSION['supp_id']; ?>">
                                <input type="hidden" name="zvehn"   class="form-control"  value="<?php echo $pass->zvehn  ?>">
                                <input type="hidden" name="shtyp"   class="form-control"  value="<?php echo $pass->shtyp; ?>" >
                                <input type="hidden" name="tplst"   id="tplst" class="form-control"  value="<?php echo $pass->tplst; ?>" >
                                <input type="hidden" name="zbunt"   class="form-control"  value="<?php echo $pass->zbunt; ?>" >
                                <input type="hidden" name="zdref"   class="form-control"  value="<?php echo $pass->zdref; ?>"   >
                                <input type="hidden" name="zzins"   class="form-control"  value="<?php echo $pass->zzins; ?>"    >
                                <input type="hidden" name="cstat"   class="form-control"  value="<?php echo $pass->cstat; ?>" >
                                <label for="">Loading State</label>
                                <select  name="state" id="state" class="form-control" value="" onchange="getCities(this);" required>
                                    <option value=''>Select State </option>
                                    <?php foreach( $states as $state) { ?>
                                        <option value="<?php echo "{$state->iso2}"; ?>" <?php if($pass->state  == $state->iso2 ) { echo 'selected';}?>><?php echo "{$state->iso2} : {$state->name}"; ?></option>
                                    <?php } ?>
                                </select>
                            </th>
                            <th class="col-md-6">
                                <label for="">Loading Location</label>
                                <select  name="zzloc" id="zzloc" class="form-control" id="zzloc" required >
                                    <option value="">Select City </option>
                                    <?php foreach( $cities as $city) { ?>
                                        <option value="<?php echo $city->name; ?>" <?php if($pass->zzloc == $city->name ) { echo 'selected';}?> ><?php echo "{$city->name}"; ?></option>
                                    <?php } ?>
                                </select>    
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Driver Name</label>
                                <input type="text" name="zdnam" class="form-control" value="<?php echo $pass->zdnam; ?>"  required>
                            </td>
                            <td>
                                <label for="">Transporter Name</label>
                                <input type="text" name="ztnam" class="form-control" value="<?php echo $pass->ztnam; ?>"  required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Driver Phone</label>
                                <input type="tel" name="zmbno" class="form-control" pattern="[0-9]{10}" value="<?php echo $pass->zmbno; ?>" required>
                            </td>
                            <td>
                                <label for="">Driver License</label>
                                <input type="text" name="zlcno" class="form-control" oninput="this.value = this.value.toUpperCase();" value="<?php echo $pass->zlcno;?>"  required>    
                            </td>
                
                        </tr>
                        <tr>
                            <td>
                                <label for="">LR Number</label>
                                <input type="text" name="zlrno" class="form-control" value="<?php echo $pass->zlrno; ?>"  >
                            </td>
                            <td>
                                <label for="">LR Date</label>
                                <input type="date" name="zlrdt" class="form-control" value="<?php echo $pass->zlrdt; ?>" onfocus="this.max = new Date().toISOString().split('T')[0]" >
                            </td>                    
                        </tr>
                        <tr>
                            <td>
                                <label for="">Destination Plant</label>
                                <select  name="werks" id="werks" class="form-control"  onchange="updt_tplst(this);" required >
                                    <option value=''>Select Plant </option>
                                    <?php foreach( $plant as $plnt) { ?>
                                        <option value="<?php echo $plnt->objky; ?>" <?php if($pass->werks == $plnt->werks ) { echo 'selected';}?> ><?php echo "{$plnt->objky} : {$plnt->objnm} "; ?></option>
                                    <?php } ?>
                                    
                                </select>    
                            </td>
                            
                            <td>
                                <button type="button" name="btnClose" class="btn btn-danger  float-right  ml-2 mt-4" value="cls" onclick="window.close();">Close</button>
                                <button type="submit" name="action"   class="btn btn-primary float-right  ml-2 mt-4" value="invPass" <?php if($pass->cstat != 'VP' || $action == 'addPass' || $action == 'vehPass' || $action == 'modPass' ) { echo 'disabled';} ?>>Add Invoices</button>
                                <button type="submit" name="action"  class="btn btn-success  float-right  ml-2 mt-4"  value="<?php  switch($action) { 
                                                                                                                                        case 'addPass'  : echo 'addPass';  break; 
                                                                                                                                        case 'modPass'  : echo 'modPass';  break;
                                                                                                                                        case 'viewPass' : echo 'viewPass'; break;
                                                                                                                                } ?>" >
                                                                                                                        <?php   switch($action) {
                                                                                                                                    case 'vehPass' : echo 'Create vehPass';break; 
                                                                                                                                    case 'addPass' : echo 'Create vehPass';break;
                                                                                                                                    case 'modPass' : echo 'Update Pass'; break;
                                                                                                                                    case 'viewPass': echo 'Modify'     ; break; 
                                                                                                                                } ?></button>
                            
                            </td>
                            </form>                    
                        </tr>
                    </table>
                </div>
                <div class="col-sm-2">
                </div>
            </Div>
        </div>
    </div>
</div>
