<pre>
<?php
session_start();
require_once("../models/Course.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registerCourse"])) {
    print_r($_POST);
    $lecturerId = $_POST["lecturerId"];
    $sessionId = $_POST["session"];
    $facultyId = $_POST["faculty"];
    $departmentId = $_POST["department"];
    $courseCode = $_POST["courseCode"];
    $courseTitle = $_POST["courseTitle"];
    $units = $_POST["units"];
    $semester = $_POST["semester"]; 

    if (empty($courseCode) || empty($courseTitle) || empty($units) || !ctype_digit($sessionId) || !ctype_digit($facultyId) || !ctype_digit($departmentId)) {
        $_SESSION["error"] = "please fill in all fields";
        return header("location:../lecturer/courses.php");
    } else {
        $course = new Course();
        if ($courseReg = $course->registerCourse($facultyId, $departmentId, $lecturerId, $sessionId, $courseCode, $courseTitle, $units, $semester)) {
             $_SESSION["success"] = "$courseCode Registered Successfully";
             return header("location:../lecturer/courses.php");
        }

    }
}
?>