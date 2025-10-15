
<?php
header("application/json");
require_once __DIR__ . "/../models/Lecture.php";
require_once __DIR__ . "/../models/Attendance.php";
require_once __DIR__ . "/../models/Course.php";
require_once("../libaries/phpqrcode/qrlib.php");

$lecture = new Lecture();

$headers = getallheaders();
if ($_SERVER["REQUEST_METHOD"] == "POST" && $headers["action"] == "createLecture" && isset($_POST["hallType"]) && isset($_POST["courseId"])) {

    $lecturerId = $_POST['lecturerId'];
    $courseId = $_POST['courseId'];
    $topic = $_POST['topic'];
    $venue = $_POST['venue'] ?? NULL;
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $qrCodeDuration = $_POST['qrCodeDuration'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $hallType = $_POST['hallType'];

    switch ($hallType) {
        case 'small':
            $locationRadius = 0.02; // ~20 meters
            break;

        case 'medium':
            $locationRadius = 0.1; // ~100 meters
            break;

        case 'big':
            $locationRadius = 0.5; // ~500 meters
            break;
    }
    if (empty($latitude) || empty($longitude) || empty($locationRadius) || empty($topic) || empty($date) || empty($startTime) || empty($endTime) || empty($qrCodeDuration)) {
        echo json_encode(["response" => "All fields are required."]);
        exit();
    } else {
        // $token = bin2hex(random_bytes(16));
        $token = rand(99999, 999933);
        $expiresAt = time() + ($qrCodeDuration * 60);

        // Data inside the QR (students scan this)
        $qrData = json_encode([
            "lectureId" => $lecturerId,
            "token" => $token
        ]);

        // Path to save QR image
        $dir1 = "../assets/qrcodes/";
        $dir2 = "assets/qrcodes/";
        if (!file_exists($dir1)) {
            mkdir($dir1, 0777, true); // create directory if not exists
        }
        $filePath = $dir1 . "lecture_" . time() . ".png";
        $filePath2 = $dir2 . "lecture_" . time() . ".png"; // saving this to the database

        // Generate the QR code
        QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 8);

        $createLecture = $lecture->createLecture($lecturerId, $courseId, $topic, $venue, $date, $startTime, $endTime, $token, $expiresAt, $qrCodeDuration, $filePath2, $latitude, $longitude, $locationRadius);

        if ($createLecture["success"] == true) {
            $lectureId = $createLecture["lectureId"];

            $students = new Course();
            $registeredStudents = $students->getRegisteredStudents($courseId);


            if ($registeredStudents->num_rows > 0) {
                while ($rows = $registeredStudents->fetch_assoc()) {
                    $status = $lecture->markAbsent($lectureId, $rows["studentId"], "absent");
                }
                echo json_encode(["response" => "Lecture Created Successfully"]);
            } else {
                echo json_encode(["response" => "No students Registered"]);
            }
        } else {
            echo json_encode(["response" => "error"]);
        }
    }
}

// update qr code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $headers["action"] == "updateQrCode") {
    $lectureId =  $headers["lectureId"];

    // get the lecture
    $getLecture = $lecture->getLecture($lectureId);
    if ($getLecture->num_rows > 0) {
        while ($rows = $getLecture->fetch_assoc()) {
            $qrCodeDuration = $rows["qrCodeDuration"];
            $qrImageUrl = $rows["qrImageUrl"];
        }
        $file = "../" . $qrImageUrl;
        if (file_exists($file)) {
            unlink($file);

            // generat new token
            $token = rand(99999, 999933);
            $expiresAt = time() + ($qrCodeDuration * 60);

            // Data inside the QR (students scan this)
            $qrData = json_encode([
                "lectureId" => $lectureId,
                "token" => $token
            ]);

            // Path to save QR image
            $dir1 = "../assets/qrcodes/";
            $dir2 = "assets/qrcodes/";
            if (!file_exists($dir1)) {
                mkdir($dir1, 0777, true); // create directory if not exists
            }
            $filePath = $dir1 . "lecture_" . time() . ".png";
            $filePath2 = $dir2 . "lecture_" . time() . ".png"; // saving this to the database

            // Generate the QR code
            QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 8);

            if ($lecture->updateQrCode($lectureId, $token, $expiresAt, $filePath2)) {
                echo json_encode(["response" => "successful"]);
            } else {
                echo json_encode(["response" => "error updating QR Code"]);
            }
        } else {
            echo json_encode(["response" => $file]);
        }
    } else {
        echo json_encode(["response" => "error"]);
    }
}

// mark attendance manually
if ($_SERVER["REQUEST_METHOD"] == "POST" && $headers["action"] == "changeAttendance") {
    $id = $headers["studentId"];
    $requestType = $headers["requestType"];
    $attendance = new Attendance();

    if ($requestType === "markAbsent") {
        $absent = $attendance->markAttendance($id, "absent");
        if ($absent) {
            echo json_encode(["response" => "successful"]);
        } else {
            echo json_encode(["response" => "error marking absent"]);
        }
    }
    if ($requestType === "markPresent") {
        if ($attendance->markAttendance($id, "present")) {
            echo json_encode(["response" => "successful"]);
        } else {
            echo json_encode(["response" => "error marking present"]);
        }
    }
}
?>