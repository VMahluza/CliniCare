<?php

    require_once './connection.php';
    require_once './Includes/autoload.inc.php';
    require_once './varDump.php';

    /** @var TYPE_NAME $db */
    $patient = viewPatientById($db, $_GET['id']);

    $diagnosis = viewDiagnosis($db);


?>
<div class="diagnosis-container">
    <div class = "diagnosis-search-bar" >
        <div class="search-patient">
            <input type="search" name="search-patient" id="search-patient" placeholder="search...">
            <button type="submit" id="search-btn">search</button>
        </div>
        <a class="navbar__list-add" href="./AddDiagnosis.php?id=<?php echo $patient->getId()?>">Add Diagnosis</a>
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
                                <a class = "diagnosis__CTA-update" href="./Update_diagnosis.php?id=$person_id&diagnosis_id=$Diagnosis_id">Update</a>
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


