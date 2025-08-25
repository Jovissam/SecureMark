<?php
session_start();
require_once("../models/Faculty.php");
require_once("../models/Session.php");

if (!isset($_SESSION['lecturer'])) {
    header("Location: ../index.php");
    exit();
} else {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php require("../partials/style.php"); ?>
</head>

<body>
    <p id="lecturerId" class="d-none"><?= $_SESSION["userId"] ?></p>
    <main id="main" class="d-flex justify-content-between flex-column">
        <div class="">
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>
            <section class="container my-4">
                <!-- Course Header -->
                <div class=" containers rounded-4 mb-4 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold text-primary mb-1">MTH 101 - Introduction to Computer Science</h4>
                            <p class="text-muted mb-0">Faculty: Science | Semester: 1st | Units: 3</p>
                            <small class="text-secondary">Session: 2024/2025</small>
                        </div>
                        <div>
                            <button class="btn btn-succ containers">
                                <i class="fas fa-plus"></i> New Lecture
                            </button>
                            <button class="btn btn-d containers">
                                <i class="fas fa-users"></i> View Students
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class=" text-center containers rounded-4 p-3">
                            <h6 class="text-muted">Total Lectures</h6>
                            <h4 class="fw-bold text-primary">12</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center containers rounded-4 p-3">
                            <h6 class="text-muted">Registered Students</h6>
                            <h4 class="fw-bold text-success">120</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center containers rounded-4 p-3">
                            <h6 class="text-muted">Avg Attendance</h6>
                            <h4 class="fw-bold color1">84%</h4>
                        </div>
                    </div>
                </div>

                <!-- Lectures List -->
                <div class=" containers rounded-4">
                    <div class=" d-flex justify-content-between align-items-center p-3">
                        <h5 class="mb-0">Lectures Created</h5>
                        <button class="btn btn-outline-primary btn-sm">Export Attendance</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Topic</th>
                                    <th>Status</th>
                                    <th>Attendance Rate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <tr>
                                    <td>1</td>
                                    <td>2025-03-01</td>
                                    <td>Introduction & Course Overview</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>90%</td>
                                    <td>
                                        <div class="btn-group bt containers" role="group">
                                            <button class="btn btn-outline-primary">View</button>
                                            <button class="btn btn-outline-dark">Edit</button>
                                            <button class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2025-03-08</td>
                                    <td>Basics of Algorithms</td>
                                    <td><span class="badge bg-warning text-dark">Upcoming</span></td>
                                    <td>—</td>
                                    <td>
                                        <div class="btn-group bt containers" role="group">
                                            <button class="btn btn-outline-primary">View</button>
                                            <button class="btn btn-outline-dark">Edit</button>
                                            <button class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- End Example Row -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
        <footer class="color-bg-2 text-white">
            <div class="text-center mt-3 ">
                <p>&copy;copyrights <?= date("Y") ?></p>
                <small>Designed By Jovinci</small>
            </div>
        </footer>
    </main>
    <script src="../assets/javascript/main.js"></script>
    <script src="../assets/javascript/lecturerCourse.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$_SESSION["error"] = "";
$_SESSION["success"] = "";
?>