<?php
require_once("../models/Course.php");
require_once("../models/Lecture.php");
require_once("../models/Attendance.php");
require_once("../models/User.php");
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
} else {
    $studentId = $_SESSION["userId"];

    $courses = new Course();
    $registeredCourses = $courses->getStudentCourses($studentId);
    $registeredCourseId = [];
    if ($registeredCourses->num_rows > 0) {
        while ($row = $registeredCourses->fetch_assoc()) {
            $registeredCourseId[] = $row["courseId"];
        }
        $values = implode(",", $registeredCourseId);
        $lecture = new Lecture();
        $getStudentLectures = $lecture->getStudentLectures($values);
    }
    // GET PREVIOUS LECTURES
    $attendance = new Attendance();
    $prevAttendance = $attendance->getPreviousAttendance($studentId);

    $user = new User();
    $getUser = $user->getStudent($studentId);
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <?php require("../partials/style.php"); ?>
</head>

<body>
    <main id="main" class="d-flex justify-content-between flex-column min-vh-100">
        <div>
            <!-- Navbar -->
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>

            <!-- Profile Section -->
            <section class="container">
                <div class="d-flex containers rounded-4 py-4 my-4 align-items-center">
                    <div class="mx-3">
                        <img width="120px" class="profile-pic img-fluid rounded-circle border border-3"
                            src="../assets/images/icons/profile.png" alt="Student Profile">
                    </div>
                    <?php if ($getUser->num_rows > 0):?>
                    <?php while ($data = $getUser->fetch_assoc()):?>
                        <div class="profile-info fw-bold d-flex flex-column align-items-start justify-content-center">
                        <h2 class="mb-1">Welcome, <span class="text-primary"><?= $data["lastName"]?></span></h2>
                        <p class="text-muted mb-1">Department of <?= $data["department"]?></p>
                        <p class="badge bg-primary fs-6 px-3">Mat-No: <?= $data["matNo"]?></p>
                    </div>
                    <?php endwhile?>
                    <?php endif?>
                    
                </div>

                <!-- Dashboard Row -->
                <div class="row">
                    <!-- Tools & Upcoming Lectures -->
                    <div class="col-md-6">
                        <!-- Tools Section -->
                        <div class="container mb-4">
                            <h5 class="fw-bold mb-3">📌 Quick Tools</h5>
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4 hover-effect">
                                        <a href="">
                                            <img src="../assets/images/icons/fingerprint-scan.png" width="40px" alt="">
                                            <p class="mt-2">Mark Attendance</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4 hover-effect">
                                        <a href="courses.php">
                                            <img src="../assets/images/icons/course.png" width="40px" alt="">
                                            <p class="mt-2">My Courses</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4 hover-effect">
                                        <a href="">
                                            <img src="../assets/images/icons/attendance.png" width="40px" alt="">
                                            <p class="mt-2">Attendance Log</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 offset-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4 hover-effect">
                                        <a href="">
                                            <img src="../assets/images/icons/notification.png" width="40px" alt="">
                                            <p class="mt-2">Notifications</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Lectures -->
                        <div class="my-4">
                            <h5 class="fw-bold mb-3">📅 Today Lectures</h5>
                            <div class="slider-container p-2 containers rounded-4">
                                <?php if ($getStudentLectures->num_rows > 0): ?>
                                    <?php while ($row = $getStudentLectures->fetch_assoc()) : ?>

                                        <!-- get the date -->
                                        <?php $lectureDate = explode(" ", $row["createdAt"]); ?>

                                        <?php if ($lectureDate[0] == date("Y-m-d")):?>
                                            <?php $activeLecture = true; ?>
                                            <div class="lecture-card shadow-sm rounded-4 p-3 flex-shrink-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="fw-bold text-primary mb-0"><?= $row["courseCode"] ?></h6>
                                                    <span class="badge bg-success">Today</span>
                                                </div>
                                                <p class="text-muted small mb-1"><?= $row["topic"] ?></p>
                                                <p class="small mb-1"><?= $row["venue"] ?></p>
                                                <p class="small text-secondary mb-2"><?= $row["startTime"] ?> – <?= $row["endTime"] ?></p>
                                                <div class="text-center">
                                                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                        <a href="markAttendance.php?lectureId=<?= $row["id"]?>">Mark Attendance</a>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endwhile ?>
                                    <?php if (!isset($activeLecture)):?>
                                        <h5 class="text-center color2">No Lectures Today Yet</h5>
                                    <?php endif?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Lectures -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">📖 Previous Lectures</h5>
                        <div class="containers rounded-4 p-3">
                            <div class="lecture-list">
                                <?php if ($prevAttendance->num_rows > 0): ?>
                                    <?php while ($rows = $prevAttendance->fetch_assoc()): ?>
                                        <div class="lecture-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <h6 class="mb-1"><span class="color1"><?= $rows["courseCode"] ?></span> <?= $rows["topic"] ?></h6>
                                                <p class="text-muted mb-0">Date: <?= $rows["lectureDate"] ?></p>
                                            </div>
                                            <?php if ($rows["status"] == "present"): ?>
                                                <img src="../assets/images/icons/present.png" width="24" height="24" alt="Present">
                                            <?php else: ?>
                                                <img src="../assets/images/icons/absent.png" width="24" height="24" alt="Absent">
                                            <?php endif ?>

                                        </div>
                                    <?php endwhile ?>
                                <?php endif ?>
                                <!-- <div class="lecture-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div>
                                        <h6 class="mb-1">Data Structures</h6>
                                        <p class="text-muted mb-0">Date: 2023-01-01</p>
                                    </div>
                                    <img src="../assets/images/icons/present.png" width="24" height="24" alt="Present">
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <!-- Footer -->
        <footer class="color-bg-2 text-white py-3 mt-auto">
            <div class="text-center">
                <p class="mb-1">&copy; <?= date("Y") ?> | Student Attendance System</p>
                <small>Designed By <strong>Jovinci</strong></small>
            </div>
        </footer>
    </main>

    <script src="../assets/javascript/main.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>