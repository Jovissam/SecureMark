<?php
session_start();
if (!isset($_SESSION['lecturer'])) {
    header("Location: ../index.php");
    exit();
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
    <main id="main" class="d-flex justify-content-between flex-column">
        <div class="">
            <section>
                <?php require_once("../partials/navbar.php"); ?>
            </section>
            <section class="container">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h4>Your Courses</h4>
                    <div class="d-flex align-items-center">
                        <div class="me-1">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fas fa-plus    ">New</i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Understood</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">

                        <div class=" rounded-4 containers lecturer-courses p-3 m-1">
                            <div class=" card-body d-flex justify-content-between align-items-center">
                                <!-- Course Info -->
                                <div class="course-info">
                                    <h5 class="mb-1 fw-bold text-primary">MTH 101</h5>
                                    <p class="mb-0 text-muted">Introduction to Computer Science</p>
                                    <small class="text-secondary">Semester: 1st | Units: 3</small>
                                </div>
                                <!-- Actions -->
                                <div class="course-actions d-flex gap-2 flex-wrap justify-content-center">
                                    <button class="btn btn-outline-primary btn-sm">View</button>
                                    <button class="btn btn-outline-success btn-sm">Attendance</button>
                                    <button class="btn btn-outline-dark btn-sm">Edit</button>
                                </div>
                            </div>
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
    <script src="../libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>