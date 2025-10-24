<?php
require_once __DIR__. "/../config/connection.php";

class User extends Connection
{
    // GET ALL students with mat no
    function allStudents($matNo){
        $stmt =$this->connection->prepare("SELECT matNo FROM students WHERE matNo = ? ");
        $stmt->bind_param("s", $matNo);
        $stmt->execute();
        $stmt->store_result();
        return $stmt;
    }

    // ADD STUDENT
    function addStudent($level, $faculty, $dept, $matNo, $firstName, $lastName, $password){
        $stmt = $this->connection->prepare("INSERT INTO students(level, facultyId, departmentId, matNo, firstName, lastName, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissss", $level, $faculty, $dept, $matNo, $firstName, $lastName, $password);
        ;
        if ($stmt->execute()) {
            return true;
        } else{
            return false;
        }
    }
    // find all users for login
    function checkUser($role, $table, $matNo, $password){
        $stmt = $this->connection->prepare("SELECT * FROM $role WHERE $table = ? AND password = ?");
        $stmt->bind_param("ss", $matNo, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    } 
    // update deviceinfo for students
    function updateDevice($deviceId, $time, $userId){
        $stmt = $this->connection->prepare("UPDATE students SET deviceId=?, lastChange=? WHERE id= ?");
        $stmt->bind_param("sii", $deviceId, $time, $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // set pending device
    function setPendingDevice($deviceId, $time, $userId){
        $stmt = $this->connection->prepare("UPDATE students SET pendingDevice=?, pendingDeviceChange=? WHERE id= ?");
        $stmt->bind_param("sii", $deviceId, $time, $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // clear pending device
    function clearPendingDevice($userId){
        $stmt = $this->connection->prepare("UPDATE students SET pendingDevice= NULL, pendingDeviceChange= NULL WHERE id= ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    // get one user
    function getUser($table, $userId){
        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    function getStudent($studentId){
        $stmt = $this->connection->prepare("SELECT a.firstName, a.lastName, a.matNo, b.name AS department FROM students a JOIN departments b ON a.departmentId = b.id WHERE a.id = ?");
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>