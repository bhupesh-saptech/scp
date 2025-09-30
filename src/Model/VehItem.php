<?php
    namespace Model;
    use Model\Conn;
    class VehItem extends Conn {
       public $pass_id = "";
       public $chln_id = "";
       public $item_id = "";
       public $ebeln   = "";
       public $ebelp   = "";
       public $matnr   = "";
       public $txz01   = "";
       public $ntmng   = "";
       public $shqty   = "";
       public $netpr   = "";
       public $lfimg   = "";
       public $vrkme   = "";
       public $netwr   = "";      
        protected function setVehItem($rqst) {
            $rqst->objky = $rqst->pass_id . $rqst->chln_id . $rqst->item_id;
            $conn = $this->connect();
            $sqls = "insert ignore 
                       into veh_item (objky,
                                      pass_id,
                                      chln_id,
                                      item_id,
                                      ebeln,
                                      ebelp,
                                      bsart,
                                      matnr,
                                      txz01,
                                      werks,
                                      lgort,
                                      ntmng,
                                      shmng,
                                      uebto,
                                      eindt,
                                      netpr,
                                      peinh,
                                      brpme,
                                      lfimg,
                                      vrkme,
                                      netwr,
                                      zpmat,
                                      zchbg,
                                      zpuom,
                                      zcomm,
                                      brokr,
                                      bname,
                                      xchar,
                                      zflag)
                            values  ( :objky,
                                      :pass_id,
                                      :chln_id,
                                      :item_id,
                                      :ebeln,
                                      :ebelp,
                                      :bsart,
                                      :matnr,
                                      :txz01,
                                      :werks,
                                      :lgort,
                                      :ntmng,
                                      :shmng,
                                      :uebto,
                                      :eindt,
                                      :netpr,
                                      :peinh,
                                      :brpme,
                                      :lfimg,
                                      :vrkme,
                                      :netwr,
                                      :zpmat,
                                      :zchbg,
                                      :zpuom,
                                      :zcomm,
                                      :brokr,
                                      :bname,
                                      :xchar
                                      :zflag)";
            $stmt = $conn->prepare($sqls);

            $rset = $stmt->execute([  ':objky'      => $rqst->objky, 
                                      ':pass_id'    => $rqst->pass_id,
                                       ':chln_id'   => $rqst->chln_id,
                                       ':item_id'   => $rqst->item_id,
                                       ':ebeln'     => $rqst->ebeln,
                                       ':ebelp'     => $rqst->ebelp,
                                       ':bsart'     => $rqst->bsart,
                                       ':matnr'     => $rqst->matnr,
                                       ':txz01'     => $rqst->txz01,
                                       ':werks'     => $rqst->werks,
                                       ':lgort'     => $rqst->lgort,
                                       ':ntmng'     => $rqst->ntmng,
                                       ':shmng'     => $rqst->shmng,
                                       ':uebto'     => $rqst->uebto,
                                       ':eindt'     => $rqst->eindt,
                                       ':netpr'     => $rqst->netpr,
                                       ':peinh'     => $rqst->peinh,
                                       ':brpme'     => $rqst->brpme,
                                       ':lfimg'     => $rqst->lfimg,
                                       ':vrkme'     => $rqst->vrkme,
                                       ':netwr'     => $rqst->netwr,
                                       ':zpmat'     => $rqst->zpmat,
                                       ':zchbg'     => $rqst->zchbg,
                                       ':zpuom'     => $rqst->zpuom,
                                       ':zcomm'     => $rqst->zcomm,
                                       ':brokr'     => $rqst->brokr,
                                       ':bname'     => $rqst->bname,
                                       ':xchar'     => $rqst->xchar,
                                       ':zflag'     => $rqst->zflag   ]  );
            $sqls = "update veh_chln 
                         set cinv_vl = ( select sum(netwr) as value 
                                           from veh_item 
                                          where pass_id = ?
                                            and chln_id = ? )
                       where pass_id = ?
                         and chln_id = ?";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute( array($rqst->pass_id,
                                          $rqst->chln_id,
                                          $rqst->pass_id,
                                          $rqst->chln_id));
           
            $sqls = "update veh_pass 
                         set netwr = ( select sum(netwr) as value 
                                         from veh_item 
                                        where pass_id = ? )
                       where pass_id = ?";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute(array($rqst->pass_id,
                                         $rqst->pass_id));
            $conn = null;
        }
        protected function modVehItem($rqst) {
            $conn = $this->connect();
            $rqst->ebeln = substr($rqst->pitem,0,10);
            $rqst->ebelp = substr($rqst->pitem,11);

            $sqls = "update veh_item set    ebeln = :ebeln,
                                            ebelp = :ebelp,
                                            matnr = :matnr,
                                            txz01 = :txz01,
                                            werks = :werks,
                                            lgort = :lgort,
                                            ntmng = :ntmng,
                                            shmng = :shmng,
                                            netpr = :netpr,
                                            peinh = :peinh,
                                            brpme = :brpme,
                                            lfimg = :lfimg,
                                            vrkme = :vrkme,
                                            netwr = :netwr,
                                            zpmat = :zpmat,
                                            zchbg = :zchbg,
                                            zpuom = :zpuom,
                                            zcomm = :zcomm,
                                            xchar = :xchar
                                    where pass_id = :pass_id
                                      and chln_id = :chln_id
                                      and item_id = :item_id ";
                            

            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute([    ':ebeln'   => $rqst->ebeln,
                                        ':ebelp'   => $rqst->ebelp,
                                        ':matnr'   => $rqst->matnr,
                                        ':txz01'   => $rqst->txz01,
                                        ':werks'   => $rqst->werks,
                                        ':lgort'   => $rqst->lgort,
                                        ':ntmng'   => $rqst->ntmng,
                                        ':shmng'   => $rqst->shmng,
                                        ':netpr'   => $rqst->netpr,
                                        ':peinh'   => $rqst->peinh,
                                        ':brpme'   => $rqst->brpme,
                                        ':lfimg'   => $rqst->lfimg,
                                        ':vrkme'   => $rqst->vrkme,
                                        ':netwr'   => $rqst->netwr,
                                        ':zpmat'   => $rqst->zpmat,
                                        ':zchbg'   => $rqst->zchbg,
                                        ':zpuom'   => $rqst->zpuom,
                                        ':zcomm'   => $rqst->zcomm,
                                        ':xchar'   => $rqst->xchar,
                                        ':pass_id' => $rqst->pass_id,
                                        ':chln_id' => $rqst->chln_id,
                                        ':item_id' => $rqst->item_id]);
            $sqls = "update veh_chln 
                        set cinv_vl = ( select sum(netwr) as value 
                                            from veh_item 
                                            where pass_id = ?
                                              and chln_id = ? )
                        where pass_id = ?
                          and chln_id = ?";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute(array( $rqst->pass_id,
                                          $rqst->chln_id,
                                          $rqst->pass_id,
                                          $rqst->chln_id));
            $sqls = "update veh_pass 
                         set netwr = ( select sum(netwr) as value 
                                            from veh_item 
                                           where pass_id = :pass_id )
                       where pass_id = :pasx_id";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute(array(':pass_id' => $rqst->pass_id,
                                          ':pasx_id'=> $rqst->pass_id));
            $conn = null;
        }
        protected function delVehItem($rqst) {
            $conn = $this->connect();
            $sqls = "delete from veh_item 
                      where pass_id = :pass_id
                        and chln_id = :chln_id
                        and item_id = :item_id";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute([ ':pass_id' => $rqst->pass_id,
                                     ':chln_id' => $rqst->chln_id,
                                     ':item_id' => $rqst->item_id]);
            $conn = null;
        }

    }
?>