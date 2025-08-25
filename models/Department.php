<?php
require_once __DIR__. "/../config/connection.php";

class Department extends Connection
{
    function query($stmt){
        return $this->connection->query($stmt);
    }
    // GET ALL FACULTIES
    function getAlldepts($facultyId){
        $stmt = "SELECT * FROM departments WHERE facultyId = $facultyId";
        return $this->query($stmt);
    }
}

?>