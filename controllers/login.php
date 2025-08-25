<?php

// check if a user exists with those data

session_start();
session_destroy();
require_once("../models/User.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // get user inputs
    $userId = trim($_POST["userId"]);
    $password = trim($_POST["password"]);
    $deviceId = trim($_POST["deviceId"]);
    if (empty($userId) || empty($password) || empty($deviceId)) {
        echo json_encode(["response" => "fill in all fields"]);
    } else {
        $hashedPassword = sha1($password);

        $users = new User();

        $student = $users->checkUser("students", "matNo", $userId, $hashedPassword);
        $lecturer = $users->checkUser("lecturers", "lecturerId", $userId, $hashedPassword);
        $admin = $users->checkUser("admins", "name", $userId, $hashedPassword);
        if ($student->num_rows > 0) {
            while ($rows = $student->fetch_assoc()) {
                // CHECK FOR FIRST TIME LOGIN
                if ($rows["deviceId"] == null) {
                    $users->updateDevice($deviceId, time(), $rows["id"]);

                    $_SESSION["user"] = true;
                    $_SESSION["userId"] = $rows["id"];
                    echo json_encode(["response" => "Login success", "role" => "student"]);
                    exit;
                }
                // CHECK IF DEVICE MATCH
                if ($rows["deviceId"] == $deviceId) {
                    $_SESSION["user"] = true;
                    $_SESSION["userId"] = $rows["id"];
                    echo json_encode(["response" => "Login success", "role" => "student"]);
                    exit;
                } else {
                    // CHECK IF THERE IS ALREADY A PENDING DEVICE
                    if ($rows["pendingDevice"] == null) {
                        $users->setPendingDevice($deviceId, time(), $rows["id"]);
                        echo json_encode(["response" => "Device not recognize please wait for 1 hour"]);
                    } else {
                        $lockPeriod = USER_LOCKDOWN; // 1 hour in seconds
                        $pendingTime = $rows["pendingDeviceChange"];
                        $timePassed = time() - $pendingTime;

                        if ($timePassed >= $lockPeriod) {
                            $users->updateDevice($rows["pendingDevice"], time(), $rows["id"]);
                            $users->clearPendingDevice($rows["id"]);

                            $_SESSION["user"] = true;
                            $_SESSION["userId"] = $rows["id"];
                            echo json_encode(["response" => "Login success", "role" => "student"]);
                        } else {
                            $timeRemaining = round(($lockPeriod - $timePassed) / 60);
                            echo json_encode(["response" => "Device not recongnize please wait for $timeRemaining minutes"]);
                        }
                    }
                }
            }
        } elseif ($lecturer->num_rows > 0) {
            while ($rows = $lecturer->fetch_assoc()) {
                $_SESSION["lecturer"] = true;
                $_SESSION["userId"] = $rows["id"];
                echo json_encode(["response" => "Login success", "role" => "lecturer"]);
                exit;
            }
        } elseif ($admin->num_rows > 0) {
            while ($rows = $admin->fetch_assoc()) {
                $_SESSION["admin"] = true;
                $_SESSION["userId"] = $rows["id"];
                echo json_encode(["response" => "Login success", "role" => "admin"]);
                exit;
            }
        }

        if ($student->num_rows <= 0 && $lecturer->num_rows <= 0 && $admin->num_rows <= 0) {
            echo json_encode(["response" => "No User Found"]);
            exit;
        }
    }
}
// echo time();
