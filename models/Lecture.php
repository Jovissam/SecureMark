<?php
require_once __DIR__. "/../config/connection.php";

class Lecture extends Connection
{
    // Create A Lecture
    function createLecture($lecturerId, $courseId, $topic, $venue, $date, $startTime, $endTime, $token, $expiresAt,  $qrCodeDuration, $qrImageUrl, $latitude, $longitude, $locationRadius){
        $stmt = $this->connection->prepare("INSERT INTO lectures(lecturerId, courseId, topic, venue, lectureDate, startTime, endTime, qrCode, qrExpiresAt, qrCodeDuration, qrImageUrl, latitude, longitude, locationRadius)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssssiisddd", $lecturerId, $courseId, $topic, $venue, $date, $startTime, $endTime, $token, $expiresAt, $qrCodeDuration, $qrImageUrl, $latitude, $longitude, $locationRadius);

        if ($stmt->execute()) {
            $lectureId = $stmt->insert_id;
            return ["success" => true, "lectureId" => $lectureId];
        } else{
            return ["success" => false];
        }
        if (!$stmt) {
    die("Prepare failed: " . $this->connection->error);
}

    }

    // get lectures for a course
    function getCourseLectures($courseId){
        $stmt = $this->connection->prepare("SELECT * FROM lectures WHERE courseId = ? ORDER BY id DESC");
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        return $stmt->get_result();
    }

    function markAbsent($lectureId, $studentId, $status){
        $stmt = "INSERT INTO attendance (lectureId, studentId, status) VALUES ($lectureId, $studentId, '$status')";
        $result = $this->connection->query($stmt);
        return $result;
    }
    // GET ONE LECTURE
    function getLecture($lectureId){
        $stmt = $this->connection->prepare("SELECT a.id, a.topic, a.venue, a.lectureDate, a.startTime, a.endTime, a.qrImageUrl, a.latitude, a.longitude, a.qrCodeDuration, b.courseCode, b.courseTitle, c.firstName, c.lastName FROM lectures a JOIN courses b  ON a.courseId = b.id JOIN lecturers c ON a.lecturerId = c.id   WHERE a.id= ?");
         $stmt->bind_param("i", $lectureId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // UPDATE QR CODE
    function updateQrCode($lectureId, $qrcode, $qrExpiry, $qrImageUrl){
        $stmt = "UPDATE lectures SET qrCode = '$qrcode', qrExpiresAt = '$qrExpiry', qrImageUrl = '$qrImageUrl' WHERE id = $lectureId";
        $result = $this->connection->query($stmt);
        return $result;
    }
    
}
?>