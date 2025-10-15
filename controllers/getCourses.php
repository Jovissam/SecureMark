<?php
require_once("../models/Course.php");

$course = new Course();
$courseList = [];
$header = getallheaders();

if (isset($_GET["lecturerId"])) {
    $lecturerId = $_GET["lecturerId"];

    $courses = $course->getLecturerCourse($lecturerId);

    if ($courses->num_rows > 0) {
        while ($row = $courses->fetch_assoc()) {
            $courseList[] = $row;
        }
        echo json_encode($courseList);
    }
} elseif ($header["type"] == "department") {
    $departmentId = $header["departmentId"];
    $courses = $course->getCourseList($departmentId);

    if ($courses->num_rows > 0) {
        while ($row = $courses->fetch_assoc()) {
            $courseList[] = $row;
        }
        echo json_encode($courseList);
    } else {
        echo json_encode([]);
    }
} elseif ($header["type"] == "registerStudent") {
    $studentId = $_POST["studentId"];
    $courseId = $_POST["courseId"];

    $checkRegistration = $course->checkStudentRegistration($studentId, $courseId);
    if ($checkRegistration->num_rows == 0) {
        $result = $course->registerStudent($studentId, $courseId);
        if ($result == true) {
            echo json_encode(["response" => "success"]);
        } else {
            echo json_encode(["response" => "Failed"]);
        }
    } else {
        echo json_encode(["response" => "you are already registered Wait For Approval"]);
    }
}
