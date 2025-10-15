<!-- <pre> -->
<?php
session_start();
require_once ("models/Faculty.php");

$faculties = new Faculty();
$faculty = $faculties->getAllFaculties();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <?php require ("partials/style.php") ?>
</head>

<body>
    <main id="main" class="d-flex justify-content-between flex-column">
        <div id="top-section">
            <!-- nav bar -->
            <section>
                <?php require ("partials/navbar.php") ?>
            </section>

            <!-- form section -->
            <section class=" mt-4 position-relative">
                <div class="container containers rounded-4">
                    <div class="loader-container d-none">
                    <div class="loader"></div>
                </div>
                    <div class="row">
                        <div class="col-6 d-none d-md-block">
                            <div class="illustrators">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="assets/images/banner/banner1.svg" class="carousel-img d-block" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/images/banner/banner2.svg" class="carousel-img d-block" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/images/banner/banner3.svg" class="carousel-img d-block" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form col-12 col-md-6">

                            <div class="forms login-form">
                                <div class="text-center my-3">
                                    <i class="fas fa-user-alt fa-3x color1"></i>
                                </div>
                                <h2 class="text-center mb-1">Welcome Back</h2>
                                <p id="loginStatus" class="text-center"></p>
                                <form id="loginForm">
                                    <div class="form-floating mb-3">
                                        <input name="userId" type="text" class="form-control" id="input1" placeholder="" />
                                        <label for="input1">ID / MAT-NO</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="input2" placeholder="" />
                                        <label for="input2">Password <small>(First Name If You are A Student)</small></label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input name="password" type="checkbox" class="form-check-input" id="rememberMe" />
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button name="loginSubmit" type="submit" class="btn btn-light color-bg-1 w-50 rounded-5">Login</button>
                                    </div>
                                    <p class="text-center mt-3">new Here? <button type="button" href="register.php" class="color1 register-btn ps-2">Register now</button></p>
                                </form>
                            </div>

                            <!-- signup form -->
                            <div class="forms signup-form d-none">
                                <div class="text-center my-3">
                                    <i class="fas fa-user-alt fa-3x color1"></i>
                                </div>
                                <h2 class="text-center mb-4">Welcome Here</h2>
                                <p id="signupStatus" class="text-center"></p>

                                <form id="signupForm" method="post">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="first-name" placeholder="First Name" />
                                        <label for="first-name">First Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="last-name" placeholder="Last Name" />
                                        <label for="last-name">Last Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="mat-no" placeholder="MAt-No" />
                                        <label for="mat-no">Mat No</label>
                                    </div>

                                    <div class="mb-3">
                                        <select name="level" class="form-select py-3">
                                            <option selected>Choose Your Level</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select name="faculty" class="form-select py-3 faculty-select" aria-label="Default select example">
                                            <option selected>Choose Your Faculty</option>
                                            <?php if ($faculty->num_rows > 0) : ?>
                                                <?php while ($row = $faculty->fetch_assoc()) : ?>
                                                    <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                                                <?php endwhile ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select name="department" class="form-select py-3 department-select" aria-label="Default select example">
                                            <option selected>Choose Your Department</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-light color-bg-1 w-50 rounded-5">Register</button>
                                    </div>
                                    <p class="text-center mt-3">Already have an account?<button type="button" href="register.php" class="color1 login-btn ps-2">Login</button></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- footer -->
        <footer>
            <div class="text-center mt-3 ">
                <p>copyrights <?= date("Y")?></p>
                <p>Designed By Jovinci</p>
            </div>
        </footer>
    </main>
    <script src="assets/javascript/main.js"></script>
    <script src="assets/javascript/user.js"></script>
    <script src="libaries/bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>