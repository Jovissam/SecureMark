<?php
require_once("../models/Course.php");
session_start();
if (!isset($_SESSION['lecturer'])) {
    header("Location: ../index.php");
    exit();
} else {
    $lecturerId = $_SESSION["userId"];
    $courses = new Course();
    $course = $courses->getLecturerCourse($lecturerId);
    $lecturerIdS = [];
    while ($row = $course->fetch_assoc()) {
        $lecturerIdS[] = $row["id"];
    }
    $values = implode(",", $lecturerIdS);
    $pendingCourseList = $courses->getPendingCourse($values);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <?php require("../partials/style.php"); ?>
</head>

<body>
    <main id="main" class="d-flex flex-column min-vh-100">
        <div class="flex-grow-1">
            <!-- Navbar -->
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>

            <!-- Profile Section -->
            <section class="container">
                <div class="d-flex containers rounded-4 py-4 my-4 align-items-center">
                    <div class="mx-3">
                        <img width="120" class="profile-pic img-fluid rounded-circle border" src="../assets/images/icons/profile.png" alt="Profile">
                    </div>
                    <div class="profile-info fw-bold d-flex flex-column align-items-start justify-content-center">
                        <h2 class="mb-1">Welcome, Doe</h2>
                        <p class="text-muted mb-1">Department of Computer Science</p>
                        <span class="badge bg-primary rounded-pill px-3 py-2">Mat-No: 123456</span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Tools Section -->
                    <div class="col-md-6">
                        <div class="container">
                            <div class="row g-3 mb-4">
                                <h5 class="fw-semibold">📊 Tools</h5>
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4">
                                        <p class="mb-1">All Lectures</p>
                                        <h4 class="text-primary">20</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4">
                                        <p class="mb-1">My Courses</p>
                                        <h4 class="text-success">10</h4>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="containers rounded-4 tabs text-center fw-bold py-4">
                                        <img src="../assets/images/icons/notification.png" width="35" alt="">
                                        <p class="mt-2 mb-0">Notifications</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <h5 class="fw-semibold">⚡ Quick Actions</h5>
                            <div class="containers rounded-4 p-4">
                                <div class="d-flex flex-column gap-3">
                                    <a href="courses.php" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-book-open me-2"></i> Manage Courses
                                    </a>
                                    <a href="createLecture.php" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-plus-circle me-2"></i> Create a Lecture
                                    </a>
                                    <a href="create-lecture.php" class="btn btn-outline-success w-100">
                                        <i class="fas fa-eye    "></i> View Students
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-md-6">
                        <h5 class="fw-semibold">🕒 Pending Registrations</h5>
                        <div class="containers rounded-4 p-4">
                            <?php if ($pendingCourseList->num_rows > 0) : ?>
                                <?php while ($row = $pendingCourseList->fetch_assoc()) : ?>
                                    <div class="lecture-item d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1"><b><?= $row["firstName"] ?> <?= $row["lastName"] ?></b> registered for <span class="text-primary"><?= $row["courseCode"] ?></span></h6>
                                            <small class="text-muted">Date: <?= $row["registrationDate"] ?></small>
                                        </div>
                                        <button onclick="approveRegistration(<?= $row['id'] ?>)" href="" class="btn btn-sm btn-success">Approve</button>
                                    </div>
                                <?php endwhile ?>
                            <?php endif ?>
                            <!-- <div class="lecture-item d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                <div>
                                    <h6 class="fw-bold mb-1"><b>Jovis</b> registered for <span class="text-primary">MTH101</span></h6>
                                    <small class="text-muted">Date: 2023-01-01</small>
                                </div>
                                <a href="" class="btn btn-sm btn-success">Approve</a>
                            </div> -->

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="co mt-4 py-3">
            <div class="text-center">
                <p class="mb-1">&copy; <?= date("Y") ?> University System</p>
                <small>Designed By Jovinci</small>
            </div>
        </footer>
    </main>

    <script src="../assets/javascript/main.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        async function approveRegistration(id) {
            const registrationId = id;

            const request = await fetch("../controllers/courseRegistrations.php", {
                method: "POST",
                headers: {"registerId": registrationId,
                    "content-type": "application/json",
                    "requestType": "approveCourse"
                }
            }).then((result)=>result.json());

            if (request.status == "Approved") {
                alert("Approved")
                
            }
            
        }
    </script>
</body>

</html>