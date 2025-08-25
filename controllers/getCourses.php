<?php
require_once("../models/Course.php");

if (isset($_GET["lecturerId"])) {
    $lecturerId = $_GET["lecturerId"];
    $courseList = [];

    $course = new Course();
    $courses = $course->getLecturerCourse($lecturerId);

    if ($courses->num_rows > 0) {
        while ($row = $courses->fetch_assoc()) {
            $courseList[] = $row;
        }
        echo json_encode($courseList);
    }
}
?>