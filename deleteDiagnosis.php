<?php

//do not touch

    require_once './Includes/autoload.inc.php';
    require_once  './connection.php';

    if(isset($_GET['diagnosis_id'])){

        try {

            /** @var TYPE_NAME $db */
            $select_stmt = $db->prepare("SELECT person_id FROM diagnosis WHERE Diagnosis_id = :diagnosis_id");
            $select_stmt->execute([':diagnosis_id' => $_GET['diagnosis_id']]);

            $patientRow = $select_stmt->fetch(PDO::FETCH_ASSOC);

            $person_id = $patientRow['person_id'];

            /** @var TYPE_NAME $db */
            $del_stmt = $db->prepare("DELETE FROM diagnosis WHERE Diagnosis_id = :diagnosis_id");
            $del_stmt->execute([':diagnosis_id' => $_GET['diagnosis_id']]);

            header("location:ViewPatient.php?id=$person_id");


        }catch (PDOException $e){

            echo "Erroy deleting";

        }

    }
