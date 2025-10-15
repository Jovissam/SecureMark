<?php
require_once("../models/User.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["matNo"])) {
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $matNo = trim($_POST["matNo"]);
    $level = $_POST["level"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];

    if (empty($firstName) || empty($lastName) || empty($matNo) || !ctype_digit($level) || !ctype_digit($faculty) || !ctype_digit($department)) {
        echo json_encode(["response" => "fill in all fields"]);
    } else {
        $password = sha1($firstName);

        $students = new User();
        $allStudents = $students->allStudents($matNo);
        // CHECK IF MAT NO EXISTS
        if ($allStudents->num_rows > 0) {
            echo json_encode(["response" => "User already exists"]);
        } else {
            $student = $students->addStudent($level, $faculty, $department, $matNo, $firstName, $lastName, $password);
            // CHECK IF THE USER IS REGISTERED
            if ($student == true) {
                echo json_encode(["response" => "success"]);
            } else {
                echo json_encode(["response" => "Unable to register user"]);
            }
        }
    }
}
