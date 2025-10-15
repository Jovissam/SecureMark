<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}?>
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
                    <div class="profile-info fw-bold d-flex flex-column align-items-start justify-content-center">
                        <h2 class="mb-1">Welcome, <span class="text-primary">Doe</span></h2>
                        <p class="text-muted mb-1">Department of Computer Science</p>
                        <p class="badge bg-primary fs-6 px-3">Mat-No: 123456</p>
                    </div>
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
                            <h5 class="fw-bold mb-3">📅 Upcoming Lectures</h5>
                            <div class="slider-container p-2 containers rounded-4">
                                <div id="courseSlider" class="carousel slide">
                                    <div class="carousel-inner rounded-4 overflow-hidden">
                                        <div class="carousel-item active">
                                            <a href="">
                                                <img src="../dump/course1.jpeg" class="d-block w-100" alt="Lecture 1">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../dump/course2.jpeg" class="d-block w-100" alt="Lecture 2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../dump/course3.jpeg" class="d-block w-100" alt="Lecture 3">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#courseSlider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#courseSlider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Lectures -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">📖 Previous Lectures</h5>
                        <div class="containers rounded-4 p-3">
                            <div class="lecture-list">
                                <div class="lecture-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div>
                                        <h6 class="mb-1">Data Structures</h6>
                                        <p class="text-muted mb-0">Date: 2023-01-01</p>
                                    </div>
                                    <img src="../assets/images/icons/present.png" width="24" height="24" alt="Present">
                                </div>
                                <div class="lecture-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div>
                                        <h6 class="mb-1">Database Systems</h6>
                                        <p class="text-muted mb-0">Date: 2023-01-02</p>
                                    </div>
                                    <img src="../assets/images/icons/absent.png" width="24" height="24" alt="Absent">
                                </div>
                                <div class="lecture-item d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <h6 class="mb-1">Computer Networks</h6>
                                        <p class="text-muted mb-0">Date: 2023-01-03</p>
                                    </div>
                                    <img src="../assets/images/icons/present.png" width="24" height="24" alt="Present">
                                </div>
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
