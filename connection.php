<?php

//This file should be included to any file that needs access to our database

//Variable Strings for Db
//The commented strings are to be used when you are using localhost

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

function viewPatients($db):array{
    $patients = [];
    try {

        /** @var TYPE_NAME $db */
        $select_stmt = $db->prepare("SELECT id, patientNumber,firstname, surname, created FROM patient;");


        $select_stmt->execute();
        $rows = $select_stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($rows as $row){

            $patients[] = new Patient(

                $row['id'],
                $row['patientNumber'],
                $row['firstname'],
                $row['surname'],
                $row['created']
            );

        }
    }catch (PDOException $E){
        $pdoErro = $E->getMessage();
        echo "We have an error due to : $pdoErro";
    }
    return $patients;
}

//You can pass and patient attribute this function will work like a charm😎😎
function searchPatients($db , $str):array{
    $patients = [];
    try {

        /** @var TYPE_NAME $db */
        $select_stmt = $db->prepare("
                SELECT id, patientNumber,firstname, surname, created 
                FROM patient WHERE patientNumber LIKE :patientNumber 
                                OR firstname LIKE :firstname 
                                OR surname LIKE :surname;");

        $select_stmt->execute([
            ':patientNumber' => "%" . $str . "%",
            ':firstname' => "%" . $str . "%",
            ':surname' =>  "%" . $str . "%"
            ]);
        $rows = $select_stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($rows as $row){

            $patients[] = new Patient(

                $row['id'],
                $row['patientNumber'],
                $row['firstname'],
                $row['surname'],
                $row['created']
            );

        }
    }catch (PDOException $E){
        $pdoErro = $E->getMessage();
        echo "We have an error due to : $pdoErro";
    }
    return $patients;
}
