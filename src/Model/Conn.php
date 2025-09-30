<?php
    namespace Model;
    use \PDO;
    class Conn  {
        private  $host = "agilesaptech.com";
        private  $user = "agiletwn_bcpl";
        private  $pass = "agiletwn_bcpl";
        private  $dbnm = "agiletwn_bcpl";
        private  $options;
        private  $conn;
        public function __construct() {

        }
        public function connect() {
            try {
                $this->options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Set fetch mode to associative array
                    PDO::ATTR_EMULATE_PREPARES => false // Disable emulated prepared statements
                ];
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbnm};charset=utf8;", $this->user,$this->pass,$this->options);
            } catch (\PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
            return $this->conn;
        }
        public function execQuery($query, $param = [],$rows = 0 ) {
            $conn = $this->connect();
            $stmt = $conn->prepare($query);
            $rset = $stmt->execute($param);
            if($stmt->rowCount() > 0 ) {
                if ( $rows == 1 ) {
                    return $stmt->fetch();
                } else {
                    return $stmt->fetchAll();
                } 
            } 
            $conn = null;
        }
        public function __destruct() {
            // $this->close(); 
        }
    }
