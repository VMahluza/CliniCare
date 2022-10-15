<?php

require_once './connection.php';

$name = $_POST['name'];
/** @var TYPE_NAME $db */
$patients = searchPatients($db , $name);
echo json_encode($patients);
