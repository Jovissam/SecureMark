<?php
session_start();
header("application/json");
require_once("../models/Course.php");

// echo json_encode($_SESSION);
if (isset($_SESSION["lecturer"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $courses = new Course();
    $header = getallheaders();
    if ($header["requestType"] == "approveCourse") {
        $registrationId = $header["registerId"];
        if ($courses->approveRegistration($registrationId)) {
            echo json_encode(["status"=> "Approved"]);
        }
    }
}
?>