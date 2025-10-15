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
  <h4 class="mb-3">My Created Lectures</h4>

  <div class="table-responsive containers rounded-4 p-3 shadow-sm">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Course</th>
          <th>Topic</th>
          <th>Venue</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td><strong>MTH 101</strong><br><small>Intro to Mathematics</small></td>
          <td>Algebra Basics</td>
          <td>Main Campus Hall</td>
          <td>Sep 12, 2025</td>
          <td>10:00 - 12:00</td>
          <td><span class="badge bg-success">Active</span></td>
          <td class="d-flex gap-1 flex-wrap">
            <button class="btn btn-sm btn-outline-primary">View</button>
            <button class="btn btn-sm btn-outline-success">Attendance</button>
            <button class="btn btn-sm btn-outline-dark">Edit</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td><strong>COS 201</strong><br><small>Computer Science</small></td>
          <td>Data Structures</td>
          <td>Science LT 2</td>
          <td>Sep 15, 2025</td>
          <td>14:00 - 16:00</td>
          <td><span class="badge bg-warning text-dark">Upcoming</span></td>
          <td class="d-flex gap-1 flex-wrap">
            <button class="btn btn-sm btn-outline-primary">View</button>
            <button class="btn btn-sm btn-outline-success">Attendance</button>
            <button class="btn btn-sm btn-outline-dark">Edit</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td><strong>PHY 301</strong><br><small>Physics</small></td>
          <td>Quantum Mechanics</td>
          <td>Lab Hall</td>
          <td>Sep 1, 2025</td>
          <td>09:00 - 11:00</td>
          <td><span class="badge bg-secondary">Completed</span></td>
          <td class="d-flex gap-1 flex-wrap">
            <button class="btn btn-sm btn-outline-primary">View</button>
            <button class="btn btn-sm btn-outline-success">Attendance</button>
            <button class="btn btn-sm btn-outline-dark">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>
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