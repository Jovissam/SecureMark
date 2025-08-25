<?php
require __DIR__ . "/../models/Department.php";
if (isset($_GET["facultyId"])) {

    $facultyId = $_GET["facultyId"];
    if ($facultyId <= 0) {
        echo json_encode([]);
        exit;
    }

    $departments = [];

    $deptClass = new Department();
    $department = $deptClass->getAlldepts($facultyId);

    if ($department->num_rows > 0) {
        while ($rows = $department->fetch_assoc()) {
            $departments[] = $rows;
        }
    }
    echo json_encode($departments);
}
