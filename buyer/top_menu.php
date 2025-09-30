<?php include('../incld/autoload.php'); ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="
            <?php 
                if(isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $home_pg = $_SESSION['home_pg'];
                    if(isset($_SESSION['supp_id'])) {
                        $supp_id = $_SESSION['supp_id'];
                    }
                    echo $home_pg;
                }
            ?>" class="nav-link">
            Home
        </a>
      </li>
      <li class="nav-item">
            <select class="form-control" id="supp_id" onchange="setVendor(this);">
                <?  if(isset($_SESSION['user_id'])) {
                        $util = new Model\Util();
                        $user_id = $_SESSION['user_id'];
                        $role_nm = $_SESSION['role_nm'];
                        $query   = $_SESSION['sup_qry'];
                        if($role_nm == 'suppl' || $role_nm == 'buyer'  ) {
                            $param = array(':user_id'=>$user_id);
                        } else {
                            $param = array();
                        }
                        $items = $util->execQuery($query,$param);    
                        if(isset($items)) {
                            if(isset($_SESSION['supp_id'])) {
                                $supp_id = $_SESSION['supp_id'];
                            } else {
                                $supp_id = "";
                            }
                            if($supp_id =="") {
                                foreach($items as $item) {
                                    $supp_id = $item->lifnr;
                                    $_SESSION['supp_id'] = $supp_id;
                                    break;
                                }
                            }
                            foreach($items as $item) {
                ?>
                                <option value="<?php echo $item->lifnr; ?>" <?php if($item->lifnr == $supp_id ) { echo "selected"; } ?>> 
                                    <?php echo $item->lifnr." : ".$item->objnm; ?>
                                </option> 
                <?php
                            }
                        }
                    }
                ?>
            </select>
        </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="../suppl/index.php" class="nav-link"><img src="../assets/dist/img/go.png" width="60px" hight="6px"></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
     <?php   
            if(isset($_SESSION['supp_id'])) {
                $supp_id = $_SESSION['supp_id'];
                if($supp_id = "") {
                    echo "<h3 style='color:red;'>No Supplier is assigned to this user yet</h3>";
                }
            }
    ?>
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