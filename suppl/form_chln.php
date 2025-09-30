    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <?php include('../incld/messages.php'); ?>
                    <h1 class="card-title">Add Challans to Vehicle Pass</h1> 
                </div>
            </div>
        </div>
        <div class="card-body">
            <table  class="table table-bordered" >
    <?php   if($actn != "addChln") { ?>
                <tr>
                    <td colspan="8">
                        <form method="post" onkeydown="return preventEnter(event);">
                            <table  class="table table-bordered" >
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger float-right ml-4" onclick="window.close();" >
                                            Close
                                        </button>
                                        <button type="submit" name="action" class="btn btn-primary float-right " value="addChln">
                                            Add Invoice
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            
    <?php } ?>
                <tr>
                    <td colspan="8">
                        <table  class="table table-bordered" >
                            <tr class="bg-primary">
                                <th>
                                    <label for="">Vehicle No</label>
                                    <input type="text" name="zvehno"   class="form-control"  value="<?php echo $pass->zvehn;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">Transporter</label>
                                    <input type="text" name="ztnam"   class="form-control"  value="<?php echo $pass->ztnam;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">Driver Name</label>
                                    <input type="text" name="zdnam"   class="form-control"  value="<?php echo $pass->zdnam;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">Contact</label>
                                    <input type="text" name="zmbno"   class="form-control"  value="<?php echo $pass->zmbno;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">LR No</label>
                                    <input type="text" name="zlrno"   class="form-control"  value="<?php echo $pass->zlrno;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">LR Date</label>
                                    <input type="date" name="zlrdt"   class="form-control"  value="<?php echo $pass->zlrdt;  ?>" readonly >
                                </th>
                                <th>
                                    <label for="">Pass Value</label>
                                    <input type="text" name="netwr"   class="form-control text-right"  value="<?php echo $pass->netwr;   ?>" readonly>
                                </th>
                                <th>
                                    <label for="">Vehicle Pass</label>
                                    <input type="text" name="pass_id"  class="form-control"  value="<?php echo $pass->pass_id; ?>" readonly>    
                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php 
                if($actn == "addChln") { 
                    $query = "select count(*) as count from veh_chln where pass_id = ?";
                    $param = array($pass->pass_id);
                    $chln  = $conn->execQuery($query,$param,1);
                    if(isset($chln)) {
                        $chln->chln_id = str_pad((int)$chln->count + 1,2,'0',STR_PAD_LEFT);
                        $item = new stdClass();
                        $item->item_id = '01';
                    } else {
                        $chln = new stdClass();
                        $chln->chln_id = '01';
                        $item = new stdClass();
                        $item->item_id = '01';
                    }
                    
                ?>
                <tr class="bg-dark" id="rowChln">
                    <td colspan="8">
                        <form method="post" class="invForm" onsubmit="chkChlnForm(this, event);" autocomplete="off" onkeydown="return preventEnter(event);">
                            <table class="table table-bordered" >
                                <tr>
                                    <td>    
                                        <input type="hidden" name="pass_id" value="<?php echo $pass->pass_id; ?>" >
                                        <input type="hidden" name="chln_id" value="<?php echo $chln->chln_id;  ?>" >                            
                                        <input type="hidden" name="supp_id" class="supp_id" value="<?php echo $_SESSION['supp_id']; ?>" >
                                        <input type="hidden" name="chln_yr" class="chln_yr" value="<?php echo '2024'; ?>" >
                                        <input type="hidden" name="cinv_yr" value="<?php echo '2024'; ?>" >
                                        <label for="">Invoice No</label>
                                        <input type="text" name="cinv_no" class="form-control" value="" onblur="updtChallan(this);" required>
                                    </td>
                                    <td>
                                        <label for="">Invoice Date</label>
                                        <input type="date" name="cinv_dt" class="form-control" value="" onblur="updtChlnDt(this);" onfocus="this.max = new Date().toISOString().split('T')[0]" required>
                                    </td>    
                                    <td>
                                        <label for="">Challan No</label>
                                        <input type="text" name="chln_no" class="form-control chln_no"  value="" required >
                                        
                                    </td>
                                    <td>
                                        <label for="">Challan Date</label>
                                        <input type="date" name="chln_dt" class="form-control"  value=""  onfocus="this.max = new Date().toISOString().split('T')[0]" required> 

                                    </td>

                                    <td>
                                        <label for="">LR No</label>
                                        <input type="text" name="trlr_no" class="form-control" value="<?php echo "{$pass->zlrno}"; ?>" >
                                    </td>
                                    <td>
                                        <label for="">LR Date</label>
                                        <input type="date" name="trlr_dt" class="form-control" value="<?php echo "{$pass->zlrdt}"; ?>" onfocus="this.max = new Date().toISOString().split('T')[0]">
                                    </td>
                                    <td> 
                                        <label for="">Invoice Value</label>
                                        <input type="text"  name="cinv_vl" class="form-control text-right"  value="" readonly >
                                    </td>
                                    <td>
                                        <button type="submit" name="action" class="btn btn-primary float-right mt-4" value="newChln" >
                                            <i class="fa fa-plus"></i>
                                        </button> 
                                    </td>
                                </tr>             
                                <tr class="bg-info">
                                    <td colspan="2">
                                        <input type="hidden" name="item_id" value="<?php echo '01'; ?>" >
                                        <input type="hidden" name="ebeln"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="ebelp"   value="<?php echo ""; ?>" > 
                                        <input type="hidden" name="matnr"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="txz01"   value="<?php echo ""; ?>" > 
                                        <input type="hidden" name="werks"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="zpuom"   value="<?php echo "BAG"; ?>" >
                                        <input type="hidden" name="zcomm"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="lgort"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="bsart"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="brpme"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="xchar"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="zflag"   value="Q" >
                                        <input type="hidden" name="chln_id" class="form-control" value="<?php echo $chln->chln_id; ?>" readonly > 
                                        <input type="hidden" name="item_id" class="form-control" value="<?php echo $item->item_id; ?>" readonly > 
                                        <label for=''>PO Item</label>
                                        <select name="pitem" class="form-control select2" style="width: 100%;"  onchange="getPOItem(this);" required>
                                            <option value="">Select Purchase Order Item</option>
                                            <?php foreach($pitem as $pitm) { 
                                                $pitm->matnr = ltrim($pitm->matnr,'0');
                                                $pitm->txz01 = substr($pitm->txz01,0,10);
                                            ?>
                                                <option value="<?php echo "{$pitm->ebeln}_{$pitm->ebelp}"; ?>"><?php echo "{$pitm->ebeln}_{$pitm->ebelp} [{$pitm->matnr}]_{$pitm->txz01}_{$pitm->netpr}"; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="brokr" class="form-control" value=""; readonly>
                                        <input type="hidden" name="bname" class="form-control" value=""; readonly>
                                        <input type="text" name="broker" class="form-control" value=""; readonly>
                                        <input type="text" name="mdesc" class="form-control" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Del Date</label>
                                        <input type="text" name="eindt" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                        <label for=''>OD Tolerence</label>
                                        <input type="number" name="uebto" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Open Quantity</label>
                                        <input type="text" name="ntmng" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                        <label for=''>Schedule Qty</label>
                                        <input type="text" name="shmng" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>PO Rate</label>
                                        <input type="text" name="netpr" class="form-control text-right" value="<?php echo ""; ?>" readonly> 
                                        <label for=''>Price Unit</label>
                                        <input type="text" name="peinh" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Chln Qty</label>
                                        <input type="text" name="lfimg" class="form-control text-right"  onblur="calcAmt(this);" value="<?php echo ""; ?>" >    
                                        <label for=''>Bag Quantity</label>
                                        <input type="number" name="zchbg" class="form-control" value="<?php echo ""; ?>" >        
                                    </td>
                                    <td>
                                        <label for="">Item Value</label>
                                        <input type="text"  name="netwr" class="form-control text-right"   value="<?php echo "";?>" readonly >   
                                        <label for=''>Packing Type</label>
                                        <select name="zpmat" class="form-control" required>
                                            <option value="" selected>Select Packing Typ</option>
                                            <option value="PPBAG">PPBAG : PP Bag</option>
                                            <option value="JTBAG">JTBAG : Jute Bag</option>
                                            <option value="SPACK">SPACK : STD Pack</option>
                                        </select>  

                                    </td>
                                    <td>
                                        <label for=''>UoM</label>
                                        <input type="text" name="vrkme" class="form-control text-right"  value="<?php echo ""; ?>" readonly>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            
    <?php   } ?>
    <?php
            if(isset($chlns)) {
                foreach($chlns as $chln) { 
                    $query = "select * from veh_item where pass_id = ? and chln_id = ?";
                    $param = array($chln->pass_id,$chln->chln_id);
                    $items = $conn->execQuery($query,$param);
    ?>
                <tr>      
                    <td colspan="8">
                        <form method="post" autocomplete="off" onsubmit="chkChlnForm(this,event);" onkeydown="return preventEnter(event);" >
                            <table class="table table-bordered">
                                <tr class="bg-dark" id="rowChln">
                                    <td>
                                        <input type="hidden" name="pass_id" value="<?php echo $chln->pass_id; ?>" >
                                        <input type="hidden" name="chln_id" value="<?php echo $chln->chln_id; ?>" >
                                        <input type="hidden" name="chln_yr" class="chln_yr" value="<?php echo '2024'; ?>" >
                                        <input type="hidden" name="cinv_yr" value="<?php echo '2024'; ?>" >
                                        <label for="">Invoice No</label>
                                        <input type="text" name="cinv_no" class="form-control" value="<?php echo "{$chln->cinv_no}";?>" readonly> 
                                    </td>
                                    <td>
                                            <label for="">Invoice Date</label>
                                        <input type="date" name="cinv_dt" class="form-control" value="<?php echo "{$chln->cinv_dt}";?>" onfocus="this.max = new Date().toISOString().split('T')[0]" readonly>
                                    </td>    
                                    <td>
                                        <label for="">Challan No</label>
                                        <input type="text" name="chln_no" class="form-control chln_no"  value="<?php echo "{$chln->chln_no}";?>" readonly>
                                    </td>
                                    <td>
                                        <label for="">Challan Date</label>
                                        <input type="date" name="chln_dt" class="form-control"  value="<?php echo "{$chln->chln_dt}";?>" onfocus="this.max = new Date().toISOString().split('T')[0]" readonly> 
                                    </td>
                                    <td>
                                        <label for="">LR No</label>
                                        <input type="text" name="trlr_no" class="form-control" value="<?php echo "{$chln->trlr_no}";?>" readonly>
                                    </td>
                                    <td>
                                        <label for="">LR Date</label>
                                        <input type="date" name="trlr_dt" class="form-control" value="<?php echo "{$chln->trlr_dt}";?>" onfocus="this.max = new Date().toISOString().split('T')[0]" readonly>
                                    </td>
                                    <td>
                                        <label for="">Invoice Value</label>
                                        <input type="text"  name="cinv_vl" class="form-control text-right"  value="<?php echo "{$chln->cinv_vl}";?>" readonly >                               
                                        
                                    </td>
                                    <td>
                                        <button type="button" name="action"  onclick="modChlnForm(this);" class="btn btn-default mt-4 " value="modChln" >
                                            <i class="fa fa-edit"></i></button>
                                        </button>
                                        <button type="submit" name="action"  class="btn btn-default mt-4 ml-2" value="delChln" onclick="return confirm('Are you sure you want to delete Challan?');" >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                        
        <?php
                        $query = "select count(*) as count from veh_item where pass_id = ? and chln_id = ?";
                        $param = array($chln->pass_id,$chln->chln_id);
                        $item = $conn->execQuery($query,$param,1);
                        $item->item_id = str_pad((int)$item->count + 1,2,'0',STR_PAD_LEFT);
        ?>            
                <tr>
                    <td colspan="8">
                        <form method="post" onkeydown="return preventEnter(event);" onsubmit="chkItemForm(this,event);"> 
                            <table class="table table-bordered">
                                <tr class="bg-info">
                                    <td colspan="2">
                                        <input type="hidden" name="pass_id" value="<?php echo $pass->pass_id; ?>" >
                                        <input type="hidden" name="ebeln"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="ebelp"   value="<?php echo ""; ?>" > 
                                        <input type="hidden" name="matnr"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="txz01"   value="<?php echo ""; ?>" >  
                                        <input type="hidden" name="werks"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="zpuom"   value="<?php echo "BAG"; ?>" >
                                        <input type="hidden" name="zcomm"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="lgort"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="bsart"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="brpme"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="xchar"   value="<?php echo ""; ?>" >
                                        <input type="hidden" name="zflag"   value="Q" >
                                        <input type="hidden" name="chln_id" class="form-control" value="<?php echo $chln->chln_id; ?>" readonly > 
                                        <input type="hidden" name="item_id" class="form-control" value="<?php echo $item->item_id; ?>" readonly > 
                                        <label for=''>PO Item</label>
                                        <select name="pitem" class="form-control select2" style="width: 100%;" onchange="getPOItem(this);" required>
                                            <option value="" >Select Purchase Order Item</option>
                                            <?php foreach($pitem as $pitm) { 
                                                $pitm->matnr = ltrim($pitm->matnr,'0');
                                                $pitm->txz01 = substr($pitm->txz01,0,10);
                                            ?>
                                                <option value="<?php echo "{$pitm->ebeln}_{$pitm->ebelp}"; ?>"><?php echo "{$pitm->ebeln}_{$pitm->ebelp} [{$pitm->matnr}]_{$pitm->txz01}_{$pitm->netpr}"; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="brokr" class="form-control" value=""; readonly>
                                        <input type="hidden" name="bname" class="form-control" value=""; readonly>
                                        <input type="text"   name="broker" class="form-control" value=""; readonly>
                                        <input type="text"   name="mdesc" class="form-control" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Del Date</label>
                                        <input type="text" name="eindt" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                        <label for=''>OD Tolerence</label>
                                        <input type="number" name="uebto" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Open Quantity</label>
                                        <input type="text" name="ntmng" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                        <label for=''>Schedule Qty</label>
                                        <input type="text" name="shmng" class="form-control text-right" value="<?php echo ""; ?>" readonly>               
                                    </td>

                                    <td>
                                        <label for=''>PO Rate</label>
                                        <input type="text" name="netpr" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                        <label for=''>Price Unit</label>
                                        <input type="text" name="peinh" class="form-control text-right" value="<?php echo ""; ?>" readonly>
                                    </td>
                                    <td>  
                                        <label for=''>Chln Qty</label>
                                        <input type="text" name="lfimg" class="form-control text-right"  onblur="calcAmt(this);" value="<?php echo ""; ?>" >  
                                        <label for=''>Bag Quantity</label>
                                        <input type="number" name="zchbg" class="form-control" value="<?php echo ""; ?>" >
                                    </td>
                                    <td>
                                        <label for="">Item Value</label>
                                        <input type="text"  name="netwr" class="form-control text-right"  value="<?php echo "";?>" readonly >
                                        <label for=''>Packing Type</label>
                                        <select name="zpmat" class="form-control " required>
                                            <option value="" selected>Select Packing Typ</option>
                                            <option value="PPBAG">PPBAG : PP Bag</option>
                                            <option value="JTBAG">JTBAG : Jute Bag</option>
                                            <option value="SPACK">SPACK : Std Pakage</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label for=''>UoM</label>
                                        <input type="text" name="vrkme" class="form-control text-right"  value="<?php echo ""; ?>" readonly>
                                        <button type="submit" name="action"  class="btn btn-primary float-right mt-4" value="newItem" >
                                            <i class="fa fa-plus"></i>
                                        </button> 
                                    </td>
                                </tr>
                            </table>
                        </form> 
                    </td>
                </tr>                     
        <?php 
            if(isset($items)) {
                $cnt = 0;
                foreach($items as $item) {
                    $cnt = $cnt + 1; ?>
                <tr>
                    <td colspan="8">
                        <form method="post" autocomplete="off" onkeydown="return preventEnter(event);" onsubmit="chkItemForm(this,event);">
                            <table class="table table-bordered">
                                <tr class="bg-secondary">
                                    <td colspan="2">
                                        <input type="hidden" name="pass_id" value="<?php echo $item->pass_id; ?>" >
                                        <input type="hidden" name="ebeln"   value="<?php echo $item->ebeln; ?>" >
                                        <input type="hidden" name="ebelp"   value="<?php echo $item->ebelp; ?>" > 
                                        <input type="hidden" name="matnr"   value="<?php echo $item->matnr; ?>" >
                                        <input type="hidden" name="txz01"   value="<?php echo $item->txz01; ?>" > 
                                        <input type="hidden" name="werks"   value="<?php echo $item->werks; ?>" >
                                        <input type="hidden" name="zpuom"   value="<?php echo $item->zpuom; ?>" >
                                        <input type="hidden" name="zcomm"   value="<?php echo $item->zcomm; ?>" >
                                        <input type="hidden" name="brpme"   value="<?php echo $item->brpme; ?>" >
                                        <input type="hidden" name="lgort"   value="<?php echo $item->lgort; ?>" >
                                        <input type="hidden" name="bsart"   value="<?php echo $item->bsart; ?>" >
                                        <input type="hidden" name="xchar"   value="<?php echo $item->xchar; ?>" >
                                        <input type="hidden" name="zflag"   value="<?php echo $item->zflag; ?>" >
                                        <input type="hidden" name="chln_id" class="form-control" value="<?php echo $item->chln_id; ?>" readonly > 
                                        <input type="hidden" name="item_id" class="form-control" value="<?php echo $item->item_id; ?>" readonly > 
                                        <label for=''>PO Item</label>
                                        <select name="pitem" class="form-control select2" style="width: 100%;" onchange="getPOItem(this);" required disabled>
                                            <option value="" >Select Purchase Order Item</option>
                                            <?php foreach($pitem as $pitm) { 
                                                $item->matnr = ltrim($item->matnr,'0');
                                                $item->txz01 = substr($item->txz01,0,10);
                                            ?>
                                                <option value="<?php echo "{$pitm->ebeln}_{$pitm->ebelp}"; ?>" <?php if(($item->ebeln == $pitm->ebeln) && ( $item->ebeln == $pitm->ebeln)) {echo "selected";}?>><?php echo "{$item->ebeln}_{$item->ebelp} [{$item->matnr}]_{$item->txz01}_{$item->netpr}"; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="brokr" class="form-control" value="<?php echo "{$item->brokr}"; ?>" readonly>
                                        <input type="hidden" name="bname" class="form-control" value="<?php echo "{$item->bname}"; ?>" readonly>
                                        <input type="text" name="broker" class="form-control" value="<?php echo ltrim($item->brokr,"0")."_{$item->bname}"; ?>"; readonly>
                                        <input type="text" name="mdesc" class="form-control" value="<?php echo ltrim($item->matnr,"0")."_{$item->txz01}"; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Del Date</label>
                                        <input type="text" name="eindt" class="form-control text-right" value="<?php echo "{$item->eindt}"; ?>" readonly>
                                        <label for=''>OD Tolerence</label>
                                        <input type="number" name="uebto" class="form-control text-right" value="<?php echo "{$item->uebto}"; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Open Quantity</label>
                                        <input type="text" name="ntmng" class="form-control text-right" value="<?php echo "{$item->ntmng}"; ?>" readonly>
                                        <label for=''>Schedule Qty</label>
                                        <input type="text" name="shmng" class="form-control text-right" value="<?php echo "{$item->shmng}"; ?>" readonly>                
                                    </td>
                                    <td>
                                        <label for=''>PO Rate</label>
                                        <input type="text" name="netpr" class="form-control text-right" value="<?php echo "{$item->netpr}"; ?>" readonly>
                                        <label for=''>Price Unit</label>
                                        <input type="text" name="peinh" class="form-control text-right" value="<?php echo "{$item->peinh}"; ?>" readonly>
                                    </td>
                                    <td>
                                        <label for=''>Chln Qty</label>
                                        <input type="text" name="lfimg" class="form-control text-right"  onblur="calcAmt(this);" value="<?php echo "{$item->lfimg}"; ?>" readonly>    
                                        <label for=''>Bag Quantity</label>
                                        <input type="number" name="zchbg" class="form-control text-right" value="<?php echo "{$item->zchbg}"; ?>" readonly >
                                    </td>
                                    <td>
                                        <label for="">Item Value</label>
                                        <input type="text"  name="netwr" class="form-control text-right"  value="<?php echo "{$item->netwr}";?>" readonly >                                
                                        <label for=''>Packing Type</label>
                                        <select name="zpmat" class="form-control " disabled>
                                            <option value="" selected>Select Packing Typ</option>
                                            <option value="PPBAG" <?php if($item->zpmat == 'PPBAG') { echo 'selected'; } ?>>PPBAG : PP Bag</option>
                                            <option value="JTBAG" <?php if($item->zpmat == 'JTBAG') { echo 'selected'; } ?>>JTBAG : Jute Bag</option>
                                            <option value="SPACK" <?php if($item->zpmat == 'SPACK') { echo 'selected'; } ?>>SPACK : STD Pack</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label for=''>UoM</label>
                                        <input type="text" name="vrkme" class="form-control text-right "  value="<?php echo "{$item->vrkme}"; ?>" readonly>
                                        <button type="button" name="action"  onclick="modItemForm(this);" class="btn btn-default mt-4 " value="modItem" >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="submit" name="action"  class="btn btn-default mt-4 ml-2" value="delItem" onclick="return confirm('Are you sure you want to delete Item?');"   <?php if($cnt == 1) { echo 'readonly' ;} ?>>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                            
        <?php           }
                    }
                }
            }
        ?>
            </table>
        </div>
    </div>
</div>
