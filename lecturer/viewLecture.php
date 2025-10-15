<?php
session_start();
require_once("../models/Lecture.php");
require_once("../models/Attendance.php");

if (!isset($_SESSION['lecturer'])) {
    header("Location: ../index.php");
    exit();
} else {
    $lectureId = $_GET["lectureId"];
    $i = 1;
    $lecture = new Lecture();
    $getLecture = $lecture->getLecture($lectureId);

    $attendance = new Attendance();
    $getAllAttendance = $attendance->getAllAttendance($lectureId);

    $totalStudents = $getAllAttendance->num_rows;

    $getPresentStudents = $attendance->getAttendanceStatus($lectureId, "present")->num_rows;
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
            <?php if ($getLecture->num_rows > 0) : ?>
                <?php while ($rows = $getLecture->fetch_assoc()) : ?>
                    <section class="container my-4">
                        <!-- Lecture Header -->
                        <div class="containers rounded-4 p-4 shadow-sm mb-4">
                            <h3 class="fw-bold text-primary mb-2">Lecture: <?= $rows["topic"] ?></h3>
                            <p class="mb-1"><strong>Course:</strong> <?= $rows["courseCode"] ?> - <?= $rows["courseTitle"] ?></p>
                            <p class="mb-1"><strong>Lecturer:</strong> <?= $rows["firstName"] ?> <?= $rows["lastName"] ?></p>
                            <p class="mb-1"><strong>Venue:</strong> <?= $rows["venue"] ?></p>
                            <p class="mb-1"><strong>Date:</strong> <?= $rows["lectureDate"] ?></p>
                            <p class="mb-1"><strong>Time:</strong> <?= $rows["startTime"] ?> - <?= $rows["endTime"] ?></p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                        </div>
                        <div class="row g-4">
                            <div class="col-6 col-md-4 offset-md-2 ">
                                <div class="containers rounded-4 p-3 shadow-sm text-center mb-4">
                                    <b>Total Students</b><br>
                                    <?php if ($totalStudents > 0) :?>
                                        <b><?= $totalStudents?></b>
                                        <?php else:?>
                                            <b>0</b>
                                    <?php endif?>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="containers rounded-4 p-3 shadow-sm text-center mb-4">
                                    <b>Total Present</b><br>
                                    <?php if ($getPresentStudents > 0) :?>
                                        <b><?= $getPresentStudents?></b>
                                        <?php else:?>
                                            <b>0</b>
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                        <!-- QR Code + Map -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="containers rounded-4 p-3 shadow-sm text-center">
                                    <h5 class="mb-3">Lecture QR Code</h5>
                                    <img src="../<?= $rows["qrImageUrl"] ?>" alt="QR Code" class="img-fluid" width="300">

                                    <p class="mt-2 text-muted"><b>This code is valid for <?= $rows["qrCodeDuration"] ?> Minutes</b></p>
                                    <p class="mt-2 text-muted"><small>Scan to mark attendance</small></p>
                                    <form id="updateQr" method="post">
                                        <input type="hidden" value="<?= $rows["id"] ?>" name="lectureId" ><br>
                                        <button type="submit" class="btn color-bg-1 rounded-4">Regenerate Code</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="containers rounded-4 p-3 shadow-sm">
                                    <h5 class="mb-3">Lecture Location</h5>
                                    <div class="ratio ratio-16x9">
                                        <!-- Map -->
                                        <iframe src="https://maps.google.com/maps?q=<?= $rows["latitude"] ?>,<?= $rows["longitude"] ?>&z=15&output=embed"
                                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                    <p class="mt-2 text-muted"><small>Latitude: <?= $rows["latitude"] ?> | Longitude: <?= $rows["longitude"] ?> | Radius: 50m</small></p>
                                </div>
                            </div>
                        </div>

                        <!-- Registered Students -->
                        <div class="containers rounded-4 p-3 shadow-sm mt-4">
                            <h5 class="mb-3">Registered Students</h5>
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Matric No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($getAllAttendance->num_rows > 0): ?>
                                        <?php while ($mark = $getAllAttendance->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $i++?></td>
                                                <td><?= $mark["matNo"]?></td>
                                                <td><?= $mark["firstName"]?> <?= $mark["lastName"]?></td>
                                                <?php if ( $mark["status"] == "present"): ?>
                                                <td><span class="badge bg-success"><?= $mark["status"]?></span></td>
                                                <?php else:?>
                                                    <td><span class="badge bg-danger"><?= $mark["status"]?></span></td>
                                                <?php endif?>
                                                <td>
                                                <div class="btn-group bt containers" role="group">
                                                    <button onclick="changeAttendance(<?= $mark['id']?>, 'markPresent')" class="btn btn-outline-primary"><i class="fas fa-check    "></i></a></button>
                                                    <button onclick="changeAttendance(<?= $mark['id']?>, 'markAbsent')" class="btn btn-outline-danger"><i class="fas fa-times    "></i></button>
                                                </div>
                                            </td>
                                            </tr>
                                        <?php endwhile ?>
                                    <?php else: ?>
                                        <tr>
                                            <td rowspan="5">No Students Registered</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 mt-4">
                            <button class="btn btn-outline-primary">Edit Lecture</button>
                            <button class="btn btn-outline-success">Download Attendance</button>
                        </div>
                    </section>
                <?php endwhile ?>
            <?php endif ?>



        </div>
        <footer class="color-bg-2 text-white">
            <div class="text-center mt-3 ">
                <p>&copy;copyrights <?= date("Y") ?></p>
                <small>Developed By Jovinci</small>
            </div>
        </footer>
    </main>
    <script src="../assets/javascript/main.js"></script>
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        async function changeAttendance(id, action) {
            console.log("heyyy");
            
            const studentId = id;

            const request = await fetch ("../controllers/lecture.php", {
                method: "POST",
                headers:{
                    "studentId": studentId,
                    "content-type": "application/json",
                    "action": "changeAttendance",
                    "requestType": action
                }
            }).then((result)=>result.json())
            if (request.response == "successful") {
                alert("successful")
                    window.location.reload();
            } else{
                alert(request.response)
            }
        }

        const updateQr = document.getElementById("updateQr");

        updateQr.addEventListener("submit", async (e) => {
            e.preventDefault();
                const lectureId = e.target[0].value;

                const request = await fetch ("../controllers/lecture.php", {
                    method: "POST",
                    headers:{
                        "lectureId": lectureId,
                        "content-type": "application/json",
                        "action": "updateQrCode",
                    }
                }).then((result) => result.json())
                if (request.response == "successful") {
                    window.location.reload();
                }
            
        })
        
    </script>

</body>

</html>
<?php
$_SESSION["error"] = "";
$_SESSION["success"] = "";
?>