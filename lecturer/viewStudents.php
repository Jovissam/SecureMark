<?php
session_start();
require_once("../models/Course.php");

if (!isset($_SESSION['lecturer'])) {
    header("Location: ../index.php");
    exit();
} else {
    $course = new Course();
    $courses = $course->getLecturerCourse($_SESSION["userId"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create lecture</title>
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
                <!-- Course Info -->
                <div class="containers rounded-4 p-4 shadow-sm mb-4">
                    <h3 class="fw-bold text-primary mb-2">Course: MTH 101 - Introduction to Mathematics</h3>
                    <p class="mb-1"><strong>Lecturer:</strong> Dr. John Doe</p>
                    <p class="mb-1"><strong>Department:</strong> Mathematics</p>
                    <p class="mb-1"><strong>Semester:</strong> First Semester</p>
                    <p class="mb-1"><strong>Session:</strong> 2024/2025</p>
                    <p class="mb-1"><strong>Total Students:</strong> 45</p>
                </div>

                <!-- Registered Students -->
                <div class="containers rounded-4 p-3 shadow-sm">
                    <h5 class="mb-3">Registered Students</h5>
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Matric No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>MAT/2024/001</td>
                                <td>Jane Doe</td>
                                <td>jane.doe@email.com</td>
                                <td>Sep 5, 2025</td>
                                <td><span class="badge bg-success">Approved</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>MAT/2024/002</td>
                                <td>Mark Smith</td>
                                <td>mark.smith@email.com</td>
                                <td>Sep 6, 2025</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>MAT/2024/003</td>
                                <td>Sarah Lee</td>
                                <td>sarah.lee@email.com</td>
                                <td>Sep 6, 2025</td>
                                <td><span class="badge bg-danger">Rejected</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-outline-primary">Export to Excel</button>
                    <button class="btn btn-outline-success">Download PDF</button>
                    <button class="btn btn-outline-secondary">Print List</button>
                </div>
            </section>



        </div>
        <footer class="color-bg-2 text-white">
            <div class="text-center mt-3 ">
                <p>&copy;copyrights <?= date("Y") ?></p>
                <small>Developed By Jovinci</small>
            </div>
        </footer>
    </main>
    <script src="../assets/javascript/main.js"></script>
    <script src="../assets/javascript/createLecture.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$_SESSION["error"] = "";
$_SESSION["success"] = "";
?>