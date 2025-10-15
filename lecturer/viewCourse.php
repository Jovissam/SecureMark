<?php
session_start();
require_once("../models/Lecture.php");
require_once("../models/Course.php");

if (!isset($_SESSION['lecturer']) || !isset($_GET["courseId"])) {
    header("Location: ../index.php");
    exit();
} else {
    $courseId = $_GET["courseId"];
    $i = 1;

    $course = new Course();
    $getCourse = $course->getOneCourse($courseId);

    $lecture = new Lecture();
    $totalLectures = $lecture->getCourseLectures($courseId)->num_rows;

    $totalStudents = $course->getRegisteredStudents($courseId)->num_rows;

    $lectures = $lecture->getCourseLectures($courseId);
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
            <?php if ($getCourse->num_rows > 0) : ?>
                <?php while ($rows = $getCourse->fetch_assoc()) : ?>
                    <section class="container my-4">
                        <!-- Course Header -->
                        <div class=" containers rounded-4 mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="fw-bold text-primary mb-1"><?= $rows["courseCode"]?> - <?= $rows["courseTitle"]?> </h4>
                                    <p class="text-muted mb-0">Faculty: <?= $rows["faculty"]?>  | Semester: <?= $rows["semester"]?>  | Units: <?= $rows["units"]?> </p>
                                    <small class="text-secondary">Session: <?= $rows["session"]?> </small>
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
                                    <h4 class="fw-bold text-primary"><?= $totalLectures?> </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center containers rounded-4 p-3">
                                    <h6 class="text-muted">Registered Students</h6>
                                    <h4 class="fw-bold text-success"><?= $totalStudents?> </h4>
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
                                            <th>Attendance Rate</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <!-- lecture row -->
                                     <?php if ($lectures->num_rows > 0) :?>
                                     <?php while ($lectureRow = $lectures->fetch_assoc()) :?>
                                        <tr>
                                            <td><?= $i++?></td>
                                            <td><?= $lectureRow["lectureDate"]?></td>
                                            <td><?= $lectureRow["topic"]?></td>
                                            <td>90%</td>
                                            <td>
                                                <div class="btn-group bt containers" role="group">
                                                    <button class="btn btn-outline-primary"><a href="viewLecture.php?lectureId=<?= $lectureRow["id"]?>">View</a></button>
                                                    <button class="btn btn-outline-danger">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                     <?php endwhile?>
                                     <?php else:?>
                                        <tr>
                                            <th rowspan="5">No Lectures Yet</t>
                                        </tr>
                                     <?php endif?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                <?php endwhile ?>
            <?php endif ?>

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