<?php
require_once __DIR__. "/../config/connection.php";

class Course extends Connection
{
    // Register A Course
    function registerCourse($facultyId, $departmentId, $lecturerId, $sessionId, $courseCode, $courseTitle, $units, $semester){
        $stmt = $this->connection->prepare("INSERT INTO courses(facultyId, departmentId, lecturerId, sessionId, courseCode, courseTitle, units, semester)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiissis", $facultyId, $departmentId, $lecturerId, $sessionId, $courseCode, $courseTitle, $units, $semester);

        if ($stmt->execute()) {
            return true;
        } else{
            return false;
        }
    }
    // get courses for a lecturer
    function getLecturerCourse($lecturerId){
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE lecturerId = ? ORDER BY id DESC");
        $stmt->bind_param("i", $lecturerId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // get courses for a lecturer
    function getOneCourse($courseId){
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>