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
    <div class="container">

        <div class = "mb-3" >
            <div class="mb-3" style="display: flex">
                <input type="text" name="firstname" class="form-control" placeholder="Search diagnosis">
                <a class="btn btn-primary">Look</a>
            </div>
            <a class="container btn btn-primary" style="float: right" href="./AddDiagnosis.php?id=<?php echo $patient->getId()?>">Add Diagnosis</a>
        </div>
        <table class = "table">
            <thead>
            <th>DIAGNOSIS NUMBER</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            </thead>
            <tbody>

            <?php

            foreach ($diagnosis as $diagnosis){


                $Diagnosis_id = $diagnosis->getDiagnosisId();
                $person_id = $diagnosis->getPersonId();
                $title = $diagnosis->getTitle();
                $description = $diagnosis->getDescription();
                $date = $diagnosis->getDate();

                echo <<< HTML
                                    
                                <tr>
                                    <td>$Diagnosis_id</td>
                                    <td>$title</td>
                                    <td>$description</td>
                                    <td style="display: flex; padding: 10px">
                                        <a style="margin: 5px" class = "btn btn-primary" href="./ViewDiagnosis.php?id=$Diagnosis_id">View</a>
                                        <a style="margin: 5px" id="idisk" class = "btn btn-secondary" href="./UpdatePatient.php?id=$Diagnosis_id">Update</a>
                                        <a style="margin: 5px" class = "btn btn-danger" href="./deleteDiagnosis.php?diagnosis_id=$Diagnosis_id">Delete</a>
                                    </td>
                                </tr>

                            HTML;
            }

            ?>

            </tbody>
        </table>
    </div>


