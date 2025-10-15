<?php
require_once __DIR__. "/../config/connection.php";

class Faculty extends Connection
{
    function query($stmt){
        return $this->connection->query($stmt);
    }
    // GET ALL FACULTIES
    function getAllFaculties(){
        $stmt = "SELECT * FROM faculties";
        return $this->query($stmt);
    }
}

?>