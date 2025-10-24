<?php
session_start();
require_once("../models/Lecture.php");

if (isset($_SESSION['user']) && isset($_GET["lectureId"])) {
    $studentId = $_SESSION["userId"] ?? null;
    $lectureId = $_GET["lectureId"] ?? null;

    $lecture = new Lecture();
    $getLecture = $lecture->getLecture($lectureId);
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <?php require("../partials/style.php"); ?>
</head>

<body>
    <main id="main" class="d-flex justify-content-between flex-column">
        <div class="">
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>
            <section class="container">
                <section class="container py-4">
                    <!--  Lecture Details -->
                    <?php if ($getLecture->num_rows > 0): ?>
                        <?php while ($row = $getLecture->fetch_assoc()): ?>

                            <div class="containers rounded-4 shadow-sm mb-4 p-4 bg-white">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h3 class="fw-bold text-primary mb-1"><?= $row["courseCode"]?> - <?= $row["topic"]?></h3>
                                        <p class="text-muted mb-0">Venue: <strong><?= $row["venue"]?></strong></p>
                                        <p class="text-muted mb-0">Date: <strong><?= $row["lectureDate"]?></strong> | Time: <strong><?= $row["startTime"]?> - <?= $row["endTime"]?></strong></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ?>
                    <?php endif ?>
                    <!--  Status Message -->
                    <div id="statusMessage" class="text-center mt-4"></div>
                    <form id="attendance-form">
                        <!-- Hidden -->
                        <input type="hidden" id="lecture-id" name="lectureId" value="<?= $lectureId ?>">
                        <input type="hidden" id="student-id" name="studentId" value="<?= $studentId ?>">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">

                        <!--  student location -->
                        <div class="d-flex flex-column align-items-center mb-4">
                            <h4 class="fw-bold text-primary">Your Location</h4>
                            <p class="text-muted py-2">Below is your current location. Please ensure location access is granted.</p>
                            <div class="text-center ">
                                <input type="text" id="location" name="location" class="form-control" placeholder="Fetching your location..." readonly required>
                            </div>
                        </div>

                        <div id="scan-container" class="d-none  ">
                            <!--  QR Scanner Section -->
                            <div class="text-center mb-4">
                                <h4 class="fw-bold text-primary">Scan QR to Mark Attendance</h4>
                                <p class="text-muted">Align the QR code within the frame below. Please ensure camera access is granted.</p>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="card shadow-lg rounded-4 p-3 border-0" style="max-width: 420px; width: 100%;">
                                    <div class="scan-frame rounded-4 overflow-hidden position-relative">
                                        <div id="preview" class="w-100 rounded-3"></div>
                                        <div class="scan-overlay position-absolute top-50 start-50 translate-middle text-white fw-bold">
                                            <i class="bi bi-qr-code-scan fs-1"></i>
                                            <p>Scanning...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="scan-data" name="lat">

                        <!-- Controls -->
                        <div class="text-center mt-4">
                            <button type="button" id="scan-btn" class="btn btn-outline-primary rounded-pill px-4" onclick="startScanner()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Start Scan
                            </button>
                        </div>

                        <div class=" text-center mt-3">
                            <button class="btn color-bg-2 rounded-5 text-white" type="submit"> Submit Attendance </button>
                        </div>

                    </form>
                </section>

            </section>
        </div>
        <footer class="color-bg-2 text-white">
            <div class="text-center mt-3 ">
                <p>&copy;copyrights <?= date("Y") ?></p>
                <small>Designed By Jovinci</small>
            </div>
        </footer>
    </main>
    <!-- JS Libraries -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="../assets/javascript/main.js"></script>
    <script src="../assets/javascript/markAttendance.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>