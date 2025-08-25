<?php
require_once __DIR__ . "/../env.php";

class Connection 
{
    public function __construct() {
        $this->getConnection();
    }
    private $host = HOST;
    private $userName = USERNAME;
    private $password = PASSWORD;
    private $db = DATABASE;

    public $connection;

    private function getConnection(){
        $conn = new mysqli($this->host, $this->userName, $this->password, $this->db);
        if ($conn->connect_error) {
            die("unable to connect to database");
        } else {
            $this->connection = $conn;
        }
        
    }
}
?>