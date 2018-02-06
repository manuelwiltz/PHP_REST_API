<?php

class Database {
    private $host = "localhost";
    private $db_name = "api_db"; //name = 
    private $username = "root"; //pw = api$$pass$$
    private $password = "";
    private $conn;
    
    //private $db_name = "portman_api";
    //private $username = "portman_api";
    //private $password = 'api$$pass$$';
    
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
            
        } catch (PDOException $ex) {
            echo "Connection error: " . $ex->getMessage();
        }
        return $this->conn;
    }
    
}

?>
