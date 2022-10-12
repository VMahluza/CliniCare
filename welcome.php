<?php


    require_once './connection.php';
    session_start();
    if (!isset($_SESSION['user'])){
        header('location : index.php');
    }

    $title = $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['surname'];
    $title = 'User ' . ucwords(strtolower($title));

?>
<!doctype html>
<html lang="en">
<head>
    <?php require_once './htmlhead.php';?>
</head>
<body>

    <?php require_once './register_patient.php'?>
    <br>
    <a class = 'btn btn-secondary' href="logout.php">Logout</a>
</body>
</html>
