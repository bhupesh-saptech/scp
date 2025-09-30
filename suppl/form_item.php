<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <?php include('../incld/messages.php'); ?>
                <h1 class="card-title">Vehicle Pass</h1> 
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="addInvoice(this);">Add Invoice</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row" id="vehDiv">  
            <div class="col-md-2">
            </div>  
            <div class="col-md-8">
                <div class="row bg-secondary bg-gradient">
                    <div class="col">
                        <label for="">Vehicle Pass</label>
                        <input type="text" name="pass_id"  class="form-control"  value="<?php echo $pass->pass_id; ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="">Vehicle Number</label>
                        <input type="text" name="zvehno"   class="form-control"  value="<?php echo $pass->zvehn;   ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="">Transporter Name</label>
                        <input type="text" name="ztnam"   class="form-control"  value="<?php echo $pass->ztnam;   ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="">Driver Name</label>
                        <input type="text" name="zdnam"   class="form-control"  value="<?php echo $pass->zdnam;   ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="">Contact No</label>
                        <input type="text" name="zmbno"   class="form-control"  value="<?php echo $pass->zmbno;   ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <form method="POST">
            <div class="row">
                <div class="col-md-2">
                    <input type="hidden" name="pass_id" class="form-control" value="<?php echo $pass->pass_id; ?>" readonly>
                    <input type="hidden" name="chln_no" class="form-control" value="<?php echo $rqst->chln_no; ?>" readonly>
                    <input type="hidden" name="chln_dt" class="form-control" value="<?php echo $rqst->chln_dt; ?>" readonly>
                    <input type="hidden" name="zlrno"   class="form-control" value="<?php echo $rqst->zlrno;   ?>" readonly>
                    <input type="hidden" name="zlrdt"   class="form-control" value="<?php echo $rqst->zlrdt;   ?>" readonly>
                    <input type="hidden" name="lifnr"   class="form-control" value="<?php echo $rqst->lifnr;   ?>" readonly>
                    <input type="hidden" name="wrbtr"   class="form-control" value="<?php echo $rqst->wrbtr;   ?>" readonly>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Invoice No</label>
                                <input type="text" name="cinv_no" class="form-control" value="<?php echo $rqst->cinv_no; ?>" readonly>
                            </div>    
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Invoice Dt</label>
                                <input type="text" name="cinv_dt" class="form-control" value="<?php echo $rqst->cinv_dt; ?>" readonly>
                            </div>    
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Invoice ID</label>
                                <input type="text" name="chln_id" class="form-control" value="<?php echo $_POST['chln_id']; ?>" readonly>
                            </div>    
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Item ID</label>
                                <input type="text" name="item_id" class="form-control" value="<?php echo $_POST['item_id']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Order Number</label>
                                <input type="text" name="ebeln" class="form-control" value="<? echo "{$item->ebeln}"; ?>" readonly >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Line Item</label>
                                <input type="text" name="ebelp" class="form-control" value="<? echo "{$item->ebelp}"; ?>" readonly  >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Sch Qty</label>
                                <input type="text" name="lfimg" class="form-control"  value="" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">PO Rate</label>
                                <input type="text" name="netpr" class="form-control" value="<? echo "{$item->netpr}"; ?>" readonly  >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Material</label>
                                <input type="text" name="matnr" class="form-control" value="<? echo ltrim($item->matnr,'0'); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" name="txz01" class="form-control" value="<? echo "{$item->txz01}"; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Challan Qty</label>
                                <input type="text" name="lfimg" class="form-control" value=""  >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">UoM</label>
                                <input type="text" name="meins" class="form-control" value="<? echo "{$item->meins}"; ?>" readonly >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" name="setItem"  class="btn btn-success float-right">Add Item</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </form>
    </div>
</div>
                
