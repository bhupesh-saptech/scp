<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Details </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Form</li>
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Display User</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <form method="POST"  autocomplete="off">
                        <table class="table table-bordered">
                            <tr>
                                <td class="col-sm-6">
                                    <input type="hidden" id="action" value="<?php echo $action; ?>">
                                    <label class="form-label" for="">User ID</label>
                                    <input type="text" id="user_id" name="user_id" class="form-control" value="<?php echo $user->user_id; ?>" <?php if($action != 'add') { echo 'required'; } ?> readonly>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                                <td class="col-sm-6">
                                    <label class="form-label" for="">User Name</label>
                                    <input type="text" id= "user_nm" name="user_nm" class="form-control"  value="<?php echo $user->user_nm; ?>"  required  readonly>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label" for="">Email ID</label>
                                    <input type="email" id="mail_id" name="mail_id" class="form-control"  value="<?php echo $user->mail_id;?>" required readonly>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                                <td>
                                    <label class="form-label" for="">Phone Number</label>
                                    <input type="text"  id="user_ph" name="user_ph" class="form-control"  value="<?php echo $user->user_ph;?>" required readonly>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label" for="">Password</label>
                                    <input type="password" name="pass_wd" class="form-control"  value="<?php echo $user->pass_wd; ?>" required readonly>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                                <td>
                                    <label class="form-label" for="">User Role</label>
                                    <!-- <input name="role_id" id="objty" class="form-control" value="<?php echo "{$user->role_nm}"; ?>" readonly required> -->
                                    <select class="form-control" name="role_id" id="role_id" required readonly>
                                        <option value="<?php echo $role->role_id ?>" selected><?php echo "{$role->role_id} : {$role->role_nm}";  ?></option>
                                    </select>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label" for="">Object Type</label>
                                    <input name="objty" id="objty" class="form-control" value="<?php echo "{$objt->objty}"; ?>" readonly required>

                                </td>
                                <td>
                                    <label class="form-label" for="">Object Value</label>
                                    <select class="form-control" name="objky" id="objky" onchange="getObjects(this);"  required disabled>
                                        <option value="">select OB Value</option>
                                        <?php foreach($items as $item) { ?>
                                            <option value="<?php echo "{$item->objky}"; ?>" <?php if($item->objky == $user->objky) {echo 'selected';} ?>><?php echo "{$item->objky} : {$item->objnm}"; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label" for="">User Type</label>
                                    <select name="user_ty" class="form-control" required disabled> 
                                        <option value=""        <?php if($user->user_ty == ""       ) { echo 'selected';} ?>>select user type   </option>
                                        <option value="manager" <?php if($user->user_ty == "manager") { echo 'selected';} ?>>Manager            </option>
                                        <option value="user"    <?php if($user->user_ty == "user"   ) { echo 'selected';} ?>>User               </option>
                                    </select>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                                <td>
                                    <label class="form-label" for="">User Status</label>
                                    <select name="user_st" class="form-control" required disabled> 
                                        <option value=""  <?php if($user->user_st == "" ) { echo 'selected';} ?>>select user status </option>
                                        <option value="1" <?php if($user->user_st == "1") { echo 'selected';} ?>>Active           </option>
                                        <option value="0" <?php if($user->user_st == "0") { echo 'selected';} ?>>Inactive         </option>
                                    </select>
                                    <span class="error" name="error" style="color:red;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" name="btnClose" class="btn btn-danger  float-right ml-4" value="cls" onclick="window.close();">Close</button>
                                    <button type="button" id="setUser" name="setUser"  class="btn btn-success float-right "  value="view" onclick="btnToggle(this,event);"; >Change</button>
                    

                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>
</div>

