<?php
require_once __DIR__ . "/../env.php";
echo '
           
';

if (isset($_SESSION["user"])) {
    echo '
     <nav class="navbar navbar-expand-lg navbar-light color-bg-2 text-white">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img width="50px" src="../assets/images/icons/logo.png" alt="">
                        <span class="logo">' . WEBSITE_NAME . '</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                           
                        </ul>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Notification</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav  mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" aria-current="page" href="https://unidel.edu.ng/home/">Unidel Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gpa Calculator</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
    ';
} elseif (isset($_SESSION["lecturer"])) {
    echo '
     <nav class="navbar navbar-expand-lg navbar-light color-bg-2 text-white">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img width="50px" src="../assets/images/icons/logo.png" alt="">
                        <span class="logo">' . WEBSITE_NAME . '</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Courses</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav  mb-2 mb-lg-0">
                            
                            <li class="log-out nav-item">
                                <a class="nav-link" href="../controllers/logout.php">Log Out</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
    ';
} else {
    echo '
     <nav class="navbar navbar-expand-lg navbar-light color-bg-2 text-white">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img width="50px" src="../assets/images/icons/logo.png" alt="">
                        <span class="logo">' . WEBSITE_NAME . '</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            
                        </ul>
                        <ul class="navbar-nav  mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" aria-current="page" href="https://unidel.edu.ng/home/">Unidel Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gpa Calculator</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
    ';
}
