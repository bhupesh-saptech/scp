<?php
    namespace Model;
    use Model\Util;
    class User extends Util {
        public $user_id = "";
        public $pass_wd = "";
        public $user_nm = "";
        public $mail_id = "";
        public $user_ph = "";
        public $role_id = "";
        public $user_ty = "user";
        public $user_st = "1";
        public $objty = "PLNT";
        public $objky = "";
        protected function logUser($rqst) {
            $conn = new Conn();
            $query = "select * from usr_data where user_id = ? and pass_wd = ?";
            $param = array($rqst->user_id,$rqst->pass_wd);
            $user  = $conn->execQuery($query,$param,1);
            if(isset($user)) {
                $_SESSION['user_id']    = $user->user_id;
                $_SESSION['role_nm']    = $user->role_nm;
                $_SESSION['home_pg']    = $user->home_pg;
                $_SESSION['user_nm']    = $user->user_nm;
                $_SESSION['user_ty']    = $user->user_ty;
                switch($user->objty) {
                    case 'SUPL' : $_SESSION['supp_id']    = $user->objky; break;
                    default     : $_SESSION['plnt_id']    = $user->objky; break;
                }
                
                if(isset($_SESSION['page_id'])) {
                    $page_id = $_SESSION['page_id'];
                } else {
                    $page_id = $user->home_pg;
                }
                $conn = null;
                header("Location: ".$page_id);  
                exit(0);
            } else {
                $_SESSION['status'] = 'User Name/Password not valid';
            }
            
        }
        protected function getUser($query,$param=[],$rows=0) {
            $stmt = $this->connect()->prepare($query);
            $rset = $stmt->execute($param);
            if($rows == 1) {
                return $stmt->fetch();
            } else {
                return $stmt->fetchAll();
            }
        }
        protected function setUser($rqst) {
            $this->writeLog(json_encode($rqst));
            $conn = $this->connect();
            $sqls = "insert into users( user_id,
                                        pass_wd,      
                                        user_nm,
                                        mail_id,
                                        user_ph,
                                        role_id,
                                        user_ty,
                                        user_st,
                                        objty,
                                        objky )
                                values( :user_id,
                                        :pass_wd,
                                        :user_nm,
                                        :mail_id,
                                        :user_ph,
                                        :role_id,
                                        :user_ty,
                                        :user_st,
                                        :objty,
                                        :objky)"; 
            $stmt = $conn->prepare($sqls);
            try {
            $rset = $stmt->execute(['user_id' => $rqst->user_id,
                                    'pass_wd' => $rqst->pass_wd,
                                    'user_nm' => $rqst->user_nm,
                                    'mail_id' => $rqst->mail_id,
                                    'user_ph' => $rqst->user_ph,
                                    'role_id' => $rqst->role_id,
                                    'user_ty' => $rqst->user_ty,
                                    'user_st' => $rqst->user_st,
                                    'objty'   => $rqst->objty,
                                    'objky'   => $rqst->objky ]);  
            } catch (PDOException $e) {
                $this->writeLog("Error: { $e->getMessage()}");
            }  
        }
        protected function modUser($rqst) {
            $sqls = "update users set   pass_wd = ?,      
                                        user_nm = ?,
                                        mail_id = ?,
                                        user_ph = ?,
                                        role_id = ?,
                                        user_ty = ?,
                                        user_st = ?,
                                        objty   = ?,
                                        objky   = ?
                                  where user_id = ? "; 
            $stmt = $this->connect()->prepare($sqls);
            $rset = $stmt->execute(array($rqst->pass_wd,
                                         $rqst->user_nm,
                                         $rqst->mail_id,
                                         $rqst->user_ph,
                                         $rqst->role_id,
                                         $rqst->user_ty,
                                         $rqst->user_st,
                                         $rqst->objty,
                                         $rqst->objky,
                                         $rqst->user_id));            
        }
    }
?>