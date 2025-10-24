<?php
require_once __DIR__. "/../config/connection.php";

class Attendance extends Connection
{
    // GET ALL ATTENDANCE FOR A LECTURE
    function getAllAttendance($lectureId){
        $stmt = $this->connection->prepare("SELECT a.id, a.status, b.firstName, b.lastName, b.matNo FROM attendance a JOIN students b ON a.studentId = b.id WHERE lectureId = ?");
        $stmt->bind_param("i", $lectureId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // MARK A STUDENT ABSENT OR PRESENT
    function markAttendance($id, $action){
        $stmt = $this->connection->prepare("UPDATE attendance SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $action, $id);
        if ($stmt->execute()) {
            return true;
        }else {
            return false;
        }

    }

    //  GET EITHER PRESENT OR ABSENT STUDENTS
    function getAttendanceStatus($lectureId, $status){
        $stmt = $this->connection->prepare("SELECT * FROM attendance WHERE status = ? AND lectureId = ?");
        $stmt->bind_param("si", $status, $lectureId);
        $stmt->execute();
        return $stmt->get_result();
    }
    function getPreviousAttendance($studentId){
        $stmt = "SELECT a.status, b.courseTitle, b.courseCode, c.lectureDate, c.topic FROM attendance a JOIN courses b ON a.courseId = b.id JOIN lectures c ON a.lectureId = c.id WHERE a.studentId = $studentId";
        $result = $this->connection->query($stmt);
        return $result;
    }
    //  C`HECK A STUDENT ATTENDANCE STATUS
    function checkAttendanceStatus($studentId, $lectureId, $status){
        $stmt = $this->connection->prepare("SELECT * FROM attendance WHERE studentId = ? AND lectureId = ? AND status = ?");
        $stmt->bind_param("iis", $studentId, $lectureId, $status);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        }else{
            return false;
        }
    }
    // MARK A STUDENT ABSENT OR PRESENT WITH STUDENTID AND LECTURE ID
    function smartMark($studentId, $lectureId, $status){
        $stmt = $this->connection->prepare("UPDATE attendance SET status = ? WHERE studentId = ? AND lectureId = ?");
        $stmt->bind_param("sii", $status, $studentId, $lectureId);
        if ($stmt->execute()) {
            return true;
        }else {
            return false;
        }

    }
}

?>