<?php

//This file should be included to any file that needs access to our database

//Variable Strings for Db
//The commented strings are to be used when you are using localhost 
$db_host = "iu51mf0q32fkhfpl.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"; //"localhost";
$db_user = "xqo51kejv2e4gwyo"; //"root";
$db_password = "jyzogi6sggo7sqvt"; //"";
$db_name = "t749gvx28qflrkkn"; //"clinicaredb";

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
