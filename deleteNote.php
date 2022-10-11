<?php

//Do not touch
    require_once './varDump.php';
    require_once './connection.php';

    if ($_GET != null){

        $notes_id = $_GET['note_id'];
        $diagnosis_id = $_GET['diagnosis_id'];

        /** @var TYPE_NAME $db */
        $detete_stmt = $db->prepare("DELETE FROM notes WHERE notes.notes_id = :note_id");

        $detete_stmt->execute([':note_id' => $notes_id]);

        header("location:ViewDiagnosis.php?id=$diagnosis_id");

    }
