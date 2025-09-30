<?php     include('../incld/autoload.php'); 
    $sess = json_decode(json_encode($_SESSION));
    $util = new Model\Util();

    if(isset($sess->supp_id)) {
      $query = "select objky,objnm from supplier where objky = ?";
      $param = array($sess->supp_id);
      $supp  = $util->execQuery($query,$param,1);
      $supp->supp_id = ltrim($supp->objky,'0');
    }
   
    $query = "select * from usr_data where user_id = ?";
    $param = array($sess->user_id);
    $user  = $util->execQuery($query,$param,1);
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo "{$user->home_pg}";?>" class="nav-link">
            Home
        </a>
      </li>
      <li class="nav-item">
        <input type="hidden" class="form-control" id="supp_id" name="supp_id" value="<?php echo "{$supp->objky}" ;?>" readonly>
        <input type="text"   class="form-control" id="supp_nm" name="supp_nm" style="width: 225px;" value="<?php echo "{$supp->supp_id} : {$supp->objnm}" ;?>" readonly>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" name="dropd" type="button" data-toggle="dropdown" aria-expanded="false">
                <?php if(isset($_SESSION['user_nm'])) {
                        echo $_SESSION['user_nm'];
                      } else {
                          echo 'Not Logged In';
                      }
                ?>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">User Profile</a>
                <a class="dropdown-item" href="#">Messages</a>
                <form method="POST" action="../admin/logout.php">
                    <button type="submit" name="logout" class="dropdown-item">Logout</button>
                </form>
              </div>
            </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->