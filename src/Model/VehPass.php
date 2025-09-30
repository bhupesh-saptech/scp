<?php
    namespace Model;
    use Model\Util;
    class VehPass extends Util {
        public  $pass_id = "";
        public  $shtyp   = '0001';
        public  $werks   = "";
        public  $tplst   = "1010";
        public  $zbunt   = "INWD";
        public  $zvehn   = "";
        public  $ztnam   = "";
        public  $zdnam   = "";
        public  $zmbno   = "";
        public  $zlcno   = "";
        public  $zlrno   = "";
        public  $zlrdt   = "";
        public  $lifnr   = "" ;
        public  $zdref   = "PO";
        public  $zzins   = "P";
        public  $state   = "MH";
        public  $zzloc   = "";
        public  $cstat   = "VP";  
        public  $sdesc   = "create_VGP";
        public  $ntask   = "receive_VEH";
        protected function getCount($query,$param = []) {
            $stmt = $this->connect()->prepare($query);
            $rset = $stmt->execute($param);
            $list = $stmt->fetchAll();
            return $list;
        }
        protected function getPass($query,$param = []) {
            $conn = $this->connect();
            $stmt = $conn->prepare($query);
            $rset = $stmt->execute($param);    
            $list = $stmt->fetchAll();
            $conn = null;
            return $list;
        }

        protected function getVehn($zvehn) {
            $sqls = "select * from veh_data where pass_id in (select max(pass_id) from veh_pass where zvehn =  ?)";
            $stmt = $this->connect()->prepare($sqls);
            $rset = $stmt->execute(array($zvehn));
            $pass = json_decode(json_encode($stmt->fetch()));
            return $pass;
        }
        protected function setVehSupp($rqst) {
            $conn = $this->connect();
            $sqls = "insert ignore into veh_supp (pass_id,supp_id) values (?,?)";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute(array($rqst->pass_id,$rqst->supp_id));
            $conn = null;
        }
        protected function setVlog($rqst) {
            if(!isset($rqst->vlog_id)) {
                $rqst->vlog_id = 1;
            }
            $conn = $this->connect();
            $sqls = "insert ignore 
                            into veh_logs (pass_id,
                                           vlog_st,
                                           vlog_id,
                                           vlog_dt,
                                           vlog_tm,
                                           user_id) 
                                  values (:pass_id,
                                          :vlog_st,
                                          :vlog_id,
                                          curdate(),
                                          now(),
                                          :user_id)";
            $stmt = $conn->prepare($sqls);
            
            $rset = $stmt->execute(array($rqst->pass_id,
                                         $rqst->pstatus,
                                         $rqst->vlog_id,
                                         $rqst->user_id));
            $conn = null;
        }
        
        protected function modPass($rqst) {
            $pdoc = $this->connect();
            $sqls = "update veh_pass set    werks = ?,
                                            shtyp = ?,
                                            tplst = ?,
                                            zbunt = ?,
                                            zvehn = ?,
                                            ztnam = ?,
                                            zdnam = ?,
                                            zmbno = ?,
                                            zlcno = ?,
                                            zlrno = ?,
                                            zlrdt = ?,
                                            lifnr = ?, 
                                            zdref = ?,
                                            zzins = ?,
                                            state = ?,
                                            zzloc = ?,
                                            cstat = ?
                                    where   pass_id = ? ";
                             

            $stmt = $pdoc->prepare($sqls);
            $rset = $stmt->execute(array(   $rqst->werks,
                                            $rqst->shtyp,
                                            $rqst->tplst,
                                            $rqst->zbunt,
                                            $rqst->zvehn,
                                            $rqst->ztnam,
                                            $rqst->zdnam,
                                            $rqst->zmbno,
                                            $rqst->zlcno,
                                            $rqst->zlrno,
                                            $rqst->zlrdt,
                                            $rqst->lifnr,
                                            $rqst->zdref,
                                            $rqst->zzins,
                                            $rqst->state,
                                            $rqst->zzloc,
                                            $rqst->cstat,
                                            $rqst->pass_id)); 
        }
        protected function setPass($rqst) {
            $sqls = "insert into 
                                veh_pass (  erdat,
                                            erzet,
                                            ernam,
                                            werks,
                                            shtyp,
                                            tplst,
                                            zbunt,
                                            zvehn,
                                            ztnam,
                                            zdnam,
                                            zmbno,
                                            zlcno,
                                            zlrno,
                                            zlrdt,
                                            lifnr,
                                            zdref,
                                            zzins,
                                            state,
                                            zzloc,
                                            cstat )
                                values      (curdate(), curtime(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $pdos = $this->connect();
            $stmt = $pdos->prepare($sqls);
            $rset = $stmt->execute(array(   $rqst->user_id,
                                            $rqst->werks,
                                            $rqst->shtyp,
                                            $rqst->tplst,
                                            $rqst->zbunt,
                                            $rqst->zvehn,
                                            $rqst->ztnam,
                                            $rqst->zdnam,
                                            $rqst->zmbno,
                                            $rqst->zlcno,
                                            $rqst->zlrno,
                                            $rqst->zlrdt,
                                            $rqst->lifnr,
                                            $rqst->zdref,
                                            $rqst->zzins,
                                            $rqst->state,
                                            $rqst->zzloc,
                                            $rqst->cstat)); 
            $pass_id = $pdos->lastInsertId();
           return $pass_id;
           
            
        }
        protected function modVPStatus($rqst) {
            $conn = new Conn();
            $query = "update veh_pass set cstat  = :cstat,
                                          cngdt   = NOW(),
                                          cuser   = :cuser 
                                    where pass_id = :pass_id";
            $param = array($rqst->pstatus,
                           $rqst->user_id,
                           $rqst->pass_id);
            $conn->execQuery($query,$param);
            $conn = null;
        }
        protected function getNextNo($rqst) {
            $conn  = new Conn();
            if(in_array($rqst->pstatus,['GW','UL','TW','QA','QR','QX'])) {
                $query = "select max(vlog_id) as count from veh_logs where pass_id = ? and vlog_st = ?";
                $param = array($rqst->pass_id,$rqst->pstatus);
                $item  = $conn->execQuery($query,$param,1);
                $count = $item->count; 
                $count = $count + 1;
            } else {
                $count = 1;
            }
            $conn = null;
            return $count;
        }
    }
?>