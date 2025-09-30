<?php
    if(isset($_GET['getSupplier'])) {
        $rqst = json_decode(json_encode($_GET));
        $rqst->supp_id = "%{$rqst->supp_id}%";
        $query = "select * from supplier where objky like ? or objnm like ?";
        $param = array($rqst->supp_id,$rqst->supp_id);
        $items = $util->execQuery($query,$param);
    } else {
        $items = [];
        $item = new stdClass();
        $item->supp_id = "";
        $item->objky = "";
        $item->objnm = "";
        $item->lifnr = "";
        $item->land1 = "";
        $item->regio = "";
        $item->ort01 = "";
        $item->pstlz = "";
        $item->ktokk = "";
        $item->ekgrp = "";
        array_push($items,$item);
    }
?>
<div class="card ">
    <div class="card-header">
        <?php include('../incld/messages.php'); ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <td class="text-right" style="width:60%">
                    <label class="form-label">Search Supplier</label>
                </td>
                <td style="width:40%">
                    <form>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="supp_id"   value="" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="getSupplier" value="">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <table id="dtbl" class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th>Supplier Name</th>
                    <th>Country</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Pin Code</th>
                    <th>Type</th>
                    <th>Pur.Group</th>
                    <th>Supplier</th> 
                </tr>
            </thead>
            <?php 
                if(isset($items)) {
                    foreach($items as $item) {
                        $item->supp_id = $item->lifnr;
                        $item->lifnr = ltrim($item->lifnr,'0');
            ?>
                <tr>
                    <td><?php echo $item->objnm; ?></td>      
                    <td><?php echo $item->land1; ?></td>      
                    <td><?php echo $item->regio; ?></td>      
                    <td><?php echo $item->ort01; ?></td>      
                    <td><?php echo $item->pstlz; ?></td>      
                    <td><?php echo $item->ktokk; ?></td>
                    <td><?php echo $item->ekgrp; ?></td>
                    <td class="text-center">
                        <form>
                            <input type="hidden" name="supp_id" value="<?php echo "{$item->supp_id}";?>">
                            <button type="submit" name="action" value="setVendor" class="btn btn-primary">
                                <?php echo $item->lifnr; ?>
                            </button>
                        </form>
                    </td>    
                </tr>
                <?php 
                        } 
                    }
                ?>
        </table>
    </div>
</div>

<?php
    include('../incld/jslib.php'); ?>
    <script>
        $(function () {
            $("#list_pass").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#list_pass_wrapper .col-md-6:eq(0)');

        });
        function newTab(url) {
            window.open(url,'_blank');
        }
    </script>
<?php
    include('../incld/footer.php');
?>