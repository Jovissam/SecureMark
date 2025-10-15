<?php

if (isset($_SESSION["user"]) || isset($_SESSION["lecturer"]) || isset($_SESSION["admin"])) {
    echo '
        <!-- custom font -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
            <!-- bootstrap -->
            <link rel="stylesheet" href="../libaries/bootstrap/css/bootstrap.css">
            <!-- fontawesome -->
            <link rel="stylesheet" href="../libaries/fontawesome/css/all.min.css">
            <!-- style css -->
            <link rel="stylesheet" href="../assets/css/style.css">
            <!-- responsive css -->
            <link rel="stylesheet" href="../assets/css/responsive.css">
';
} else {
    echo '
        <!-- custom font -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
            <!-- bootstrap -->
            <link rel="stylesheet" href="libaries/bootstrap/css/bootstrap.css">
            <!-- fontawesome -->
            <link rel="stylesheet" href="libaries/fontawesome/css/all.min.css">
            <!-- style css -->
            <link rel="stylesheet" href="assets/css/style.css">
            <!-- responsive css -->
            <link rel="stylesheet" href="assets/css/responsive.css">
';
}