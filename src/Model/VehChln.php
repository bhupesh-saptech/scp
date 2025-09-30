<?php
    namespace Model;
    use Model\Conn;
    class VehChln extends Conn {

        protected function setVehChln($rqst) {
            $rqst->objky = $rqst->pass_id . $rqst->chln_id;
            $conn = $this->connect();
            $sqls = "insert ignore into 
                                veh_chln   (pass_id,
                                            chln_id,
                                            supp_id,
                                            chln_no,
                                            chln_yr,
                                            chln_dt,
                                            trlr_no,
                                            trlr_dt,
                                            cinv_no,
                                            cinv_yr,
                                            cinv_dt,
                                            cinv_vl)
                                    values  (:pass_id,
                                             :chln_id,
                                             :supp_id,
                                             :chln_no,
                                             :chln_yr,
                                             :chln_dt,
                                             :trlr_no,
                                             :trlr_dt,
                                             :cinv_no,
                                             :cinv_yr,
                                             :cinv_dt,
                                             :cinv_vl)";
            $stmt = $conn->prepare($sqls);
            $rset = $stmt->execute([':pass_id' => $rqst->pass_id,
                                    ':chln_id' => $rqst->chln_id,
                                    ':supp_id' => $rqst->supp_id,
                                    ':chln_no' => $rqst->chln_no,
                                    ':chln_yr' => $rqst->chln_yr,
                                    ':chln_dt' => $rqst->chln_dt,
                                    ':trlr_no' => $rqst->trlr_no,
                                    ':trlr_dt' => $rqst->trlr_dt,
                                    ':cinv_no' => $rqst->cinv_no,
                                    ':cinv_yr' => $rqst->cinv_yr,
                                    ':cinv_dt' => $rqst->cinv_dt,
                                    ':cinv_vl' => $rqst->cinv_vl]);
        }        
        protected function modVehChln($rqst) {
            $sqls = "update veh_chln set    chln_no = :chln_no,
                                            chln_yr = :chln_yr,
                                            chln_dt = :chln_dt,
                                            trlr_no = :trlr_no,
                                            trlr_dt = :trlr_dt,
                                            cinv_no = :cinv_no,
                                            cinv_yr = :cinv_yr,
                                            cinv_dt = :cinv_dt,
                                            cinv_vl = :cinv_vl
                                    where   pass_id = :pass_id
                                      and   chln_id = :chln_id";
                            

            $stmt = $this->connect()->prepare($sqls);
            $rset = $stmt->execute([    ':chln_no' => $rqst->chln_no,
                                        ':chln_yr' => $rqst->chln_yr,
                                        ':chln_dt' => $rqst->chln_dt,
                                        ':trlr_no' => $rqst->trlr_no,
                                        ':trlr_dt' => $rqst->trlr_dt,
                                        ':cinv_no' => $rqst->cinv_no,
                                        ':cinv_yr' => $rqst->cinv_yr,
                                        ':cinv_dt' => $rqst->cinv_dt,
                                        ':cinv_vl' => $rqst->cinv_vl,
                                        ':pass_id' => $rqst->pass_id,
                                        ':chln_id' => $rqst->chln_id]);
        }
        protected function delVehChln($rqst) {
            $sqls = "delete from veh_chln
                      where pass_id = :pass_id
                        and chln_id = :chln_id ";
            $stmt = $this->connect()->prepare($sqls);
            $rset = $stmt->execute([ ':pass_id' => $rqst->pass_id,
                                     ':chln_id' => $rqst->chln_id]);
            $sqls = "delete from veh_item
                    where pass_id = :pass_id
                     and chln_id = :chln_id ";
            $stmt = $this->connect()->prepare($sqls);
            $rset = $stmt->execute([ ':pass_id' => $rqst->pass_id,
                                     ':chln_id' => $rqst->chln_id]);
        }

    }
?>