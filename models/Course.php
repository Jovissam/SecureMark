<?php
require_once __DIR__ . "/../config/connection.php";

class Course extends Connection
{
    // Register A Course
    function registerCourse($facultyId, $departmentId, $lecturerId, $sessionId, $courseCode, $courseTitle, $units, $semester)
    {
        $stmt = $this->connection->prepare("INSERT INTO courses(facultyId, departmentId, lecturerId, sessionId, courseCode, courseTitle, units, semester)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiissis", $facultyId, $departmentId, $lecturerId, $sessionId, $courseCode, $courseTitle, $units, $semester);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // get courses for a lecturer
    function getLecturerCourse($lecturerId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM courses WHERE lecturerId = ? ORDER BY id DESC");
        $stmt->bind_param("i", $lecturerId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // GET COURSES FOR A DEPARTMENT
    function getCourseList($value)
    {
        $stmt = $this->connection->prepare("SELECT courses.id, courses.courseTitle, courses.courseCode, lecturers.firstName, lecturers.lastName  
                FROM courses JOIN lecturers ON courses.lecturerId = lecturers.id WHERE courses.departmentId = ? ORDER BY id DESC");
        $stmt->bind_param("i", $value);
        $stmt->execute();
        return $stmt->get_result();
    }

    // get courses for a lecturer
    function getOneCourse($courseId)
    {
        $stmt = $this->connection->prepare("SELECT a.id, a.courseCode, a.courseTitle, a.semester, a.units, b.name AS session, c.name AS faculty 
                    FROM courses a JOIN sessions b ON a.sessionId = b.id JOIN faculties c ON a.facultyId = c.id WHERE a.id = ?");
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // register a student
    function registerStudent($studentId, $courseId)
    {
        $status = "pending";
        $stmt = $this->connection->prepare("INSERT INTO courseRegistrations(studentId, courseId, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $studentId, $courseId, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // check if student already registered
    function checkStudentRegistration($studentId, $courseId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM courseregistrations WHERE studentId = ? AND courseId = ?");
        $stmt->bind_param("ii", $studentId, $courseId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // GET PENDING COURSE REGISTRATIONS
    function getPendingCourse($values)
    {
        $stmt = "SELECT a.id, a.registrationDate, a.status, b.firstName, b.lastName, c.courseCode FROM courseregistrations a JoiN students b ON a.studentId= b.id JOIN courses c ON a.courseId=c.id WHERE courseId IN ($values) AND status='pending'";
        $result = $this->connection->query($stmt);
        return $result;
    }

    function approveRegistration($id)
    {
        $stmt = "UPDATE courseRegistrations SET status = 'approved' WHERE id = $id";
        $result = $this->connection->query($stmt);
        return $result;
    }
    // GET REGISTERED STUDENTS FOR A COURSE
    function getRegisteredStudents($courseId)
    {
        $stmt = "SELECT * FROM courseRegistrations WHERE courseId = $courseId AND status = 'approved'";
        $result = $this->connection->query($stmt);
        return $result;
    }
    // GET APPROVED COURSES REGISTERED BY A STUDENT
    function getStudentCourses($studentId){
        $stmt = "SELECT courseId FROM courseRegistrations WHERE studentId = $studentId AND status = 'approved'";
        $result = $this->connection->query($stmt);
        return $result;
    }
    
}


// $query = SELECT a. FROM aiggnment a 