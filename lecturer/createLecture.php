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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Create New Lecture</h4>
                    <a href="courses.php" class="btn btn-outline-secondary btn-sm">Back</a>
                </div>

                <div class="containers p-4 rounded-4">
                    <form id="createLectureForm">
                        <!-- Hidden -->
                        <input type="hidden" name="lecturerId" value="<?= $_SESSION['userId'] ?>">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">

                        <!-- Course -->
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="course_id">Select Course</label>

                            <?php if (isset($_GET["courseId"])) : ?>
                                <?php $singleCourse = $course->getOneCourse($_GET["courseId"]); ?>

                                <?php while ($rows = $singleCourse->fetch_assoc()): ?>
                                    <select class="form-select" id="courseId" name="courseId" required>
                                        <option selected value="<?= $rows["id"] ?>"><?= $rows["courseCode"] ?></option>
                                    </select>
                                <?php endwhile ?>

                            <?php else: ?>
                                <select class="form-select" id="course_id" name="courseId" required>
                                    <option value="" selected disabled>-- Choose Course --</option>
                                    <?php while ($rows = $courses->fetch_assoc()): ?>
                                        <option value="<?= $rows["id"] ?>"><?= $rows["courseCode"] ?></option>
                                    <?php endwhile ?>
                                </select>
                            <?php endif ?>
                            <div class="invalid-feedback">Please choose a course.</div>
                        </div>

                        <!-- Title / Description -->
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="title">Lecture Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="e.g., Introduction to Algorithms, Test" required>
                            <div class="invalid-feedback">Lecture title is required.</div>
                        </div>
                        <!-- Date / Time -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                                <div class="invalid-feedback">Select a date.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="startTime">Start Time</label>
                                <input type="time" class="form-control" id="startTime" name="startTime" required>
                                <div class="invalid-feedback">Select a start time.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="end_time">End Time</label>
                                <input type="time" class="form-control" id="endTime" name="endTime" required>
                                <div class="invalid-feedback" id="endTimeFeedback">End time must be after start time.</div>
                            </div>
                        </div>

                        <!-- Venue / Radius -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold" for="venue">Venue (optional)</label>
                                <input type="text" class="form-control" id="venue" name="venue" placeholder="e.g., LT A, Main Campus">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="course_id">Choose Hall Type</label>
                                <select class="form-select" id="course_id" name="hallType" required>
                                    <option value="" selected disabled>Choose Hall Type</option>
                                    <option value="small">Small(lecture halls)</option>
                                    <option value="medium">Medium hall</option>
                                    <option value="big">Big hall</option>
                                </select>
                                <div class="invalid-feedback">Please choose a hall type.</div>
                            </div>
                        </div>

                        <!-- Geolocation -->


                        <!-- Optional QR settings (if you want control) -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="qr_window">QR Validity Window (minutes)</label>
                                <input type="number" class="form-control" id="qr_window" name="qrWindow" min="5" max="120" value="5">
                                <div class="form-text">QR expires after this window from the start time.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Lecture Location</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="Fetching your location..." readonly required>
                                <small class="text-muted">Your current geolocation will be attached to this lecture.</small>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Create Lecture</button>
                        </div>
                    </form>
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
    <script src="../assets/javascript/createLecture.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$_SESSION["error"] = "";
$_SESSION["success"] = "";
?>