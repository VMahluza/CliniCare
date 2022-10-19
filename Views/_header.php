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
            <img style="width: 180px" src="./public/images/logo-er.svg" alt="clinicare logo">
        </div>
        <ul class="navbar__list">
            <li><a class="navbar__list-partient" href="./patientList.php">
                    <i class='fas fa-bed' style='font-size:24px;color:var(--blue)'></i> Patients
                </a>
            </li>
        </ul>
        <a class="navbar__list-partient"  href="#"><i class="fa fa-user" style="font-size:24px;color:var(--blue)"></i> - <?php echo $logged_user_name." ". $logged_user_surname?></a>
        <a class="logout-btn" id="logout-btn" href="logout.php">Logout
            <i class='fas fa-sign-out-alt' style='font-size:24px'></i>
            <span class="glyphicon glyphicon-log-out"></span>
        </a>
    </nav>
</header>

