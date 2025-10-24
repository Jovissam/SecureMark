<?php
require_once __DIR__ . "/../config/connection.php";

class Lecture extends Connection
{
    // Create A Lecture
    function createLecture($lecturerId, $courseId, $topic, $venue, $date, $startTime, $endTime, $token, $expiresAt,  $qrCodeDuration, $qrImageUrl, $latitude, $longitude, $locationRadius)
    {
        $stmt = $this->connection->prepare("INSERT INTO lectures(lecturerId, courseId, topic, venue, lectureDate, startTime, endTime, qrCode, qrExpiresAt, qrCodeDuration, qrImageUrl, latitude, longitude, locationRadius)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssssiisddd", $lecturerId, $courseId, $topic, $venue, $date, $startTime, $endTime, $token, $expiresAt, $qrCodeDuration, $qrImageUrl, $latitude, $longitude, $locationRadius);

        if ($stmt->execute()) {
            $lectureId = $stmt->insert_id;
            return ["success" => true, "lectureId" => $lectureId];
        } else {
            return ["success" => false];
        }
        if (!$stmt) {
            die("Prepare failed: " . $this->connection->error);
        }
    }

    // get lectures for a course
    function getCourseLectures($courseId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM lectures WHERE courseId = ? ORDER BY id DESC");
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        return $stmt->get_result();
    }

    function markAbsent($lectureId, $studentId, $status, $courseId)
    {
        $stmt = "INSERT INTO attendance (lectureId, studentId, status, courseId) VALUES ($lectureId, $studentId, '$status', $courseId)";
        $result = $this->connection->query($stmt);
        return $result;
    }
    // GET ONE LECTURE
    function getLecture($lectureId)
    {
        $stmt = $this->connection->prepare("SELECT a.id, a.topic, a.venue, a.lectureDate, a.startTime, a.endTime, a.qrExpiresAt, a.qrCode, a.qrImageUrl, a.latitude, a.longitude, a.locationRadius, a.qrCodeDuration, b.courseCode, b.courseTitle, c.firstName, c.lastName FROM lectures a JOIN courses b  ON a.courseId = b.id JOIN lecturers c ON a.lecturerId = c.id   WHERE a.id= ?");
        $stmt->bind_param("i", $lectureId);
        $stmt->execute();
        return $stmt->get_result();
    }
    // UPDATE QR CODE
    function updateQrCode($lectureId, $qrcode, $qrExpiry, $qrImageUrl)
    {
        $stmt = "UPDATE lectures SET qrCode = '$qrcode', qrExpiresAt = '$qrExpiry', qrImageUrl = '$qrImageUrl' WHERE id = $lectureId";
        $result = $this->connection->query($stmt);
        return $result;
    }

    // GET LECTURES FOR FOR COURSES REGISTERD BY A STUDWNT
    function getStudentLectures($values)
    {
        $stmt = "SELECT a.id, a.topic, a.venue, a.lectureDate, a.createdAt, a.startTime, a.endTime, a.qrImageUrl, a.latitude, a.longitude, a.qrCodeDuration, b.courseCode, b.courseTitle, c.firstName, c.lastName FROM lectures a JOIN courses b  ON a.courseId = b.id JOIN lecturers c ON a.lecturerId = c.id WHERE courseId IN ($values) ORDER BY id DESC";
        $result = $this->connection->query($stmt);
        return $result;
    }

    // FUNCTION TO GET THE DISTANCE FRON THE LECTURE LOCATION AND THE STUDENT with haversine formula
    function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = EARTHRADIUS; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
