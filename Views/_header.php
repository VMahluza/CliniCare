<?php
/*
    define('ROOT', __DIR__);
    $title = "CliniCare | ";

    echo $_SERVER['SCRIPT_NAME'];
    echo ROOT;

    switch ($path) {
        case ROOT . "registration.php":
            $title .= "Register";
            break;
        
        case ROOT . "\\login.php":
            $title .= "Welcome back";
            break;
    }
    */
?>
<header class="header">
    <nav class="header__navbar container">
        <div class="header__logo">
            <img src="./public/images/logo.svg" alt="clinicare logo">
        </div>
        <ul class="navbar__list">
            <li><a class="navbar__list-partient" href="./patientList.php">Patients</a></li>
            <li><a class="navbar__list-add" href="./register_patient.php">Add New Patient</a></li>
        </ul>
        <a href="#">Contact IT support</a>
    </nav>
</header>

