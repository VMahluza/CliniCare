<?php

//Do not touch
    require_once './varDump.php';
    require_once './connection.php';

    if ($_GET != null){

        $id = $_GET['id'];

        varDumber($_GET);

        /** @var TYPE_NAME $db */
        $detete_stmt = $db->prepare("DELETE FROM patient WHERE patient.id = :id");

        $detete_stmt->execute([':id' => $id]);

        header('location:patientList.php');

    }

?>
