<?php
require_once __DIR__. "/../config/connection.php";
require_once("../libaries/phpqrcode/qrlib.php");

class generateQr extends Connection
{
    

function generateLectureQRCode($lectureId, $durationMinutes, $token, $expiresAt) {
    // Data inside the QR (students scan this)
    $qrData = json_encode([
        "lectureId" => $lectureId,
        "token" => $token
    ]);

    // Path to save QR image
    $dir = "../assets/qrcodes/";
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $filePath = $dir . "lecture_" . $lectureId . ".png";

    // Generate the QR code
    QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 8);

    // Save token + expiry in DB
    $stmt = $this->connection->prepare("UPDATE lectures SET qrCode=?, qrExpiresAt=? WHERE id=?");
    $stmt->bind_param("sii", $token, $expiresAt, $lectureId);
    $stmt->execute();

    return $filePath;
}

}

?>