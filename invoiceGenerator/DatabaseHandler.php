<?php
    class DatabaseHandler
    {
        // made private so only this class have access to these variables
        private $servername;
        private $username;
        private $password;
        private $dbname;
        
        // a proctected function so that we can extend this class from other classes
        protected function connect(){
            $this->servername = "servername";
            $this->username = "username";
            $this->password = "password";
            $this->dbname = "databasename";
            
            $conn = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
            return $conn;
        }
        
        protected function close(){
            $conn = $this->connect();
            mysqli_close($conn);
        }
    }
?>
