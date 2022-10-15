<?php

//This file should be included to any file that needs access to our database

//Variable Strings for Db
//The commented strings are to be used when you are using localhost

require_once "./varDump.php";

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

//========PATIENTS==============================================
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
function viewPatientById($db, $id):Patient{
    $patient = null;
    try {

        /** @var TYPE_NAME $db */
        $select_stmt = $db->prepare("SELECT * FROM patient WHERE id = :id;");


        $select_stmt->execute([':id' => $id]);
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);




        $patient = new Patient(
            $row['id'],
            $row['patientNumber'],
            $row['firstname'],
            $row['surname'],
            $row['created']
        );

    }catch (PDOException $E){
        $pdoErro = $E->getMessage();
        echo "We have an error due to : $pdoErro";
    }
    return $patient;
}
function updatePatient($db, $id, $firstname ,$surname):bool{

    $updateStatus = false;

    try {

        //UPDATE Customers
        //SET ContactName='Alfred Schmidt', City='Hamburg';
        $select_stmt = $db->prepare("UPDATE patient SET firstname = :firstname, surname=:surname WHERE id = :id;");

        $update = $select_stmt->execute([':id'=> $id,
            ':firstname' => $firstname,
            ':surname'=>$surname]);

        if($update === true){

            $updateStatus = true;
            //if the user registers here we want them to click something to confirm
        }

    }catch (PDOException $E){
        $pdoErro = $E->getMessage();
        echo "We have an error due to : $pdoErro";
    }

    return $updateStatus;

}
//You can pass anY patient attribute this function will work like a charm😎😎
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
//========DIAGNOSIS=============================================
function viewDiagnosisById($db, $id){

    $diagnose = null;
    try {

        $select_stmt = $db->prepare("SELECT * FROM diagnosis WHERE Diagnosis_id = :Diagnosis_id");

        $select_stmt->execute([':Diagnosis_id' => $id]);

        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $diagnose = new Diagnosis(
            $row['Diagnosis_id'],
            $row["person_id"],
            $row["title"],
            $row["description"],
            date('Y/m/d')
        );

    }catch (PDOException $e){

        echo "There was a problem in executing the statement from the diagnosis table";

    }

    return $diagnose;
}
function updateDiagnosis($db, $id, $title ,$describtion):bool{

    $updateStatus = false;

    try {

        //UPDATE Customers
        //SET ContactName='Alfred Schmidt', City='Hamburg';
        $select_stmt = $db->prepare("UPDATE diagnosis SET title = :title, description=:describtion 
                 WHERE Diagnosis_id = :id;");

        $update = $select_stmt->execute([':id'=> $id,
            ':title' => $title,
            ':describtion'=>$describtion]);

        if($update === true){

            $updateStatus = true;
            //if the user registers here we want them to click something to confirm
        }

    }catch (PDOException $E){
        $pdoErro = $E->getMessage();
        echo "We have an error due to : $pdoErro";
    }

    return $updateStatus;

}
function viewDiagnosis($db):array{

    try {

        $diagnosis = [];
        $select_stmt = $db->prepare("SELECT * FROM diagnosis WHERE person_id = :id");
        if (isset($_GET['id'])) $select_stmt->execute([':id' => $_GET['id']]);

        $rows = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row){

            $diagnosis[] = new Diagnosis(

                $row["Diagnosis_id"],
                $row["person_id"],
                $row["title"],
                $row["description"],
                $row['date']

            );

        }

    }catch (PDOException $e){

        echo "Failed to execute from the database check issue on the Diagnosis table";

    }

    return $diagnosis;
}
