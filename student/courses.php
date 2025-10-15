<?php
session_start();
require_once("../models/Faculty.php");
require_once("../models/User.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
} else {
    $userId = $_SESSION["userId"];

    $getUser = new User();
    $user = $getUser->getUser("students", $userId);
    $userData = $user->fetch_assoc();

    $faculties = new Faculty();
    $faculty = $faculties->getAllFaculties();
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
    <p id="departmentId" class="d-none"><?= $userData["facultyId"] ?></p>
    <p id="studentId" class="d-none"><?= $userId?></p>
    <main  id="main" class="d-flex justify-content-between flex-column">
        <div class="">
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>
            <section class="container">
                <p class="text-center text-danger"><?= $_SESSION["error"] ?? "" ?></p>
                <p class="text-center text-success"><?= $_SESSION["success"] ?? "" ?></p>

                <div class="d-flex justify-content-between align-items-center my-4">
                    <h4><i class="fas fa-book-open me-2 text-primary"></i>Your Courses</h4>
                    <div class="">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newCourseModal">
                            <i class="fas fa-plus"></i> New Course
                        </button>

                        <!-- modal -->
                        <div class="modal fade" id="newCourseModal" tabindex="-1" aria-labelledby="newCourseLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="newCourseLabel">Register New Course</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div class="mb-3">
                                                <select name="faculty" class="form-select faculty-select" aria-label="Default select example">
                                                    <option selected disabled>Choose Faculty</option>
                                                    <?php if ($faculty->num_rows > 0) : ?>
                                                        <?php while ($row = $faculty->fetch_assoc()) : ?>
                                                            <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                                                        <?php endwhile ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select name="department" class="form-select department-select" aria-label="Default select example">
                                                    <option selected disabled>Choose Department</option>
                                                </select>
                                            </div>
                                            <div id="courseContainer" class="row g-2">
                                            <!-- courses goes here -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row course-filter containers rounded-4 p-3 mb-4">
                    <div class="col-md-6">
                        <label for="course" class="form-label">Search Course</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" id="courseSearch" placeholder="e.g. CSC 201">
                            <button id="searchBtn" class="btn color-bg-1 mx-1">search</button>
                        </div>
                    </div>
                </div>
                <div id="courseContaner" class="row">
                    <!-- <div class=" rounded-4 containers lecturer-courses p-3 m-1">
                        <div class=" card-body d-flex justify-content-between align-items-center">

                            <div class="course-info">
                                <h5 class="mb-1 fw-bold text-primary">MTH 101</h5>
                                <p class="mb-0 text-muted">Introduction to Computer Science</p>
                                <small class="text-secondary">Semester: 1st | Units: 3</small>
                            </div>

                            <div class="course-actions d-flex gap-2 flex-wrap justify-content-end justify-content-md-center">
                                <button class="btn btn-outline-primary btn-sm">View</button>
                                <button class="btn btn-outline-success btn-sm">Attendance</button>
                                <button class="btn btn-outline-dark btn-sm">Edit</button>
                            </div>
                        </div>
                    </div> -->
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
    <script src="../assets/javascript/studentCourse.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$_SESSION["error"] = "";
$_SESSION["success"] = "";
?>