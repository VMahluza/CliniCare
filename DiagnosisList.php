<?php

    session_start();

    require_once './connection.php';
    require_once './Includes/autoload.inc.php';
    require_once './varDump.php';

    $diagnosis = [];

    try {


    //    $select_stmt->execute([':email' => $email]);
    //
    //    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


        /** @var TYPE_NAME $db */
        $select_stmt = $db->prepare("SELECT id, patientNumber,firstname, surname, created FROM patient WHERE id = :id;");

        if (isset($_GET['id'])) $select_stmt->execute([':id' => $_GET['id']]);

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

    $diagnosis = [];

    try {

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

?>
<div class="diagnosis-container">
    <div class = "diagnosis-search-bar" >
        <div class="">
            <input type="search" name="firstname" class="diagnosis-search-input" placeholder="Search diagnosis">
            <a class="diagnosis-search-btn">Look</a>
        </div>
        <a class="" href="./AddDiagnosis.php?id=<?php echo $patient->getId()?>">Add Diagnosis</a>
    </div>

    <?php
        if ($diagnosis){
            echo <<< HTML
                <div class="diagnosis-cards">
            HTML;

            foreach ($diagnosis as $diagnosis){
                $Diagnosis_id = $diagnosis->getDiagnosisId();
                $person_id = $diagnosis->getPersonId();
                $title = $diagnosis->getTitle();
                $description = $diagnosis->getDescription();
                $date = $diagnosis->getDate();

                echo <<< HTML
                        <div class="diagnosis-card">
                            <h3 class="diagnosis-card__title">$title</h3>
                            <h4 class="diagnosis-card__id">Diagnosis ID: $Diagnosis_id</h4>
                            <p class="diagnosis-card__description">$description</p>
                            <div class="diagnosis-card__CTAs">
                                <a class = "diagnosis__CTA-view" href="./ViewDiagnosis.php?id=$Diagnosis_id">View</a>
                                <a class = "diagnosis__CTA-update" href="./UpdatePatient.php?id=$Diagnosis_id">Update</a>
                                <a class ="diagnosis__CTA-delete" href="./deleteDiagnosis.php?diagnosis_id=$Diagnosis_id">Delete</a>
                            </div>
                        </div>
                HTML;
            }

            echo <<< HTML
                </div>
            HTML;

        } else {
            echo "<h5>Seems like this patient does not have any diagnosis yet, click add diagnosis to add new diagnosis</h5>";
        }
    ?>
</div>


