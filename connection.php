<?php

//This file should be included to any file that needs access to our database

//Variable Strings for Db
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "clinicaredb";

$db = null;
//Database connection
try {

    $db = new PDO("mysql:host={$db_host};dbname={$db_name}",
                                $db_user,
                                $db_password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $E){

    echo "Internal server error, database failed to connect<br>$E";

}
