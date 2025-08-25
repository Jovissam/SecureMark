<?php
require_once __DIR__. "/../config/connection.php";

class Session extends Connection
{
    function query($stmt){
        return $this->connection->query($stmt);
    }
    // GET ALL SESSIONS
    function getAllsessions(){
        $stmt = "SELECT * FROM sessions ORDER BY id DESC";
        return $this->query($stmt);
    }
}

?>