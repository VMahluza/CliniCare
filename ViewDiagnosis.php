
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

if (session_start()) {

    $logged_user_name = ucfirst(strtolower($_SESSION['user']['firstname']));
    $logged_user_surname = ucfirst(strtolower($_SESSION['user']['surname']));
    $logged_user_email = ucfirst(strtolower($_SESSION['user']['email']));
}else {

    header("location:login.php");

}

try {

    /** @var TYPE_NAME $db */
    $select_stmt = $db->prepare("SELECT id, patientNumber,firstname, surname, created FROM patient;");


    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    $patient = new Patient(

        $row['id'],
        $row['patientNumber'],
        $row['firstname'],
        $row['surname'],
        $row['created']

    );


}catch (PDOException $e){

    echo "Failed to connect to the database";

}

$diagnosis = null;

if(isset($_GET)){

    $Diagnosis_id = $_GET['id'];



    $diagnosis = viewDiagnosisById($db, $Diagnosis_id);
    $patient = viewPatientById($db, $diagnosis->getPersonId());

    $create = date_format(date_create($patient->getCreated()) , 'd M Y H:i:s');
}
//Add Note implementation
$noteInsert = null;

if (isset($_REQUEST['addnote_btn'])){

    //Validation on Notes

    if(!isset($_POST['note_discription']) || $_POST['note_discription'] == ""){

        $noteErrorMsg['note']  = "The notes field can not be empty";

    }else {

        try {

            $created = new DateTime();

            $created = $created->format('y-m-d H:i:s');

            if (isset($_POST['note_discription'])){

                $insertNote_stmt = $db->prepare("INSERT INTO notes (Diagnosis_id, description, created)
                                                    VALUES (:Diagnosis_id, :description, :created)");

                $insert =  $insertNote_stmt->execute([

                        ':Diagnosis_id'=> $diagnosis->getDiagnosisId(),
                        ':description'=> $_POST['note_discription'],
                        ':created' => $created
                ]);
            }


        }catch (PDOException $e){

            echo "Error inserting data";

        }
    }
}
//Display the notes associated with diagnosis
$notes = [];

try {

    $select_note_stmt = $db->prepare("SELECT * FROM notes WHERE Diagnosis_id = :Diagnosis_id");
    $select = $select_note_stmt->execute([':Diagnosis_id' => $diagnosis->getDiagnosisId()]);

    $rows = null;

    if ($select == true){

        $rows = $select_note_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row){

            $notes[] = new Notes(

                    $row["notes_id"],
                    $row["description"],
                    $row["Diagnosis_id"],
                    $row["created"]

            );

        }
    }

} catch (PDOException $e){

    echo "Error retrieving data from the database";

}





?>

<html lang="en">
<head>
    <?php $title = " Patient | " . $patient->getPatientNumber();
    require_once 'htmlhead.php' ?>
</head>

<body>
<?php require_once "./Views/_header.php"?>
<main class="main">
    <div class="container">

        <!--Patient-->
        <div class="patient">
            <form action="" method="post" class="container">
                <div class="patient-detail patient-number">
                    <label for="firstname" class="form-label">Patient Number</label>
                    <input type="number" disabled name="firstname" class="" value="<?php echo $patient->getPatientNumber()?>" >
                </div>
                <div class="patient-detail">
                    <label for="firstname" class="form-label">Name</label>
                    <input type="text" disabled name="firstname" class="" value="<?php echo ucwords(strtolower($patient->getFirstName()))?>">
                </div>

                <div class="patient-detail">
                    <label for="firstname" class="form-label">Surname</label>
                    <input type="text" disabled name="firstname" class="" value="<?php echo ucwords(strtolower($patient->getSurname()))?>">
                </div>

                <div class="patient-detail">
                    <label for="firstname" class="form-label">Admision date</label>
                    <input type="text" disabled name="firstname" class="" value="<?php echo $create ?>">
                </div>
            </form>
            <div class="diagnosis-container">
                <div class="diagnosis-cards">
                    <form class="form-group" style="width: 100%;" action="./register_patient.php" method="post">
                            <h2>Diagnosis Information</h2>
                            <div class="">
                                <label for="surname" class="form-label">Title</label>
                                <input type="text" readonly name="firstname" class="form-group__input" value="<?php echo $diagnosis->getTitle()?>" placeholder="">
                            </div
                            <div class="">
                                <input type="text" readonly name="surname" class="form-group__input" value="<?php echo $diagnosis->getDescription()?>" placeholder="">
                            </div>
                    </form>

                    <form action="./ViewDiagnosis.php?id=<?php echo $diagnosis->getDiagnosisId()?>" method="post">
                        <div class="container">

                            <?php

                            if (isset($noteErrorMsg)){

                                foreach ($noteErrorMsg as $erroMsg){
                                    echo <<< ERROR
                            <div class="alert alert-danger" role="alert">
                                $erroMsg
                            </div>
                        ERROR;
                                }

                            }

                            ?>
                            <div class="form-group">
                                <div style="display: flex">
                                    <input type="text" name="note_discription" class="form-group__input"  placeholder="Type patient Notes Here...">
                                    <button type="submit" name="addnote_btn" class="diagnosis__CTA-update" style="width: 30%">Add Note</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table style="margin-top: 20px" class = "table container" >
                        <thead>
                        <th>NOTE</th>
                        <th>CREATED</th>
                        <th>ACTIONS</th>
                        </thead>
                        <tbody>

                        <?php

                        foreach ($notes as $note){

                            $note_id = $note->getNotesId();
                            $note_data = $note->getNotes();
                            $created_date = $note->getCreated();
                            $diagnosis_id = $note->getDiagnosisId();

                            echo <<< HTML
                                
                            <tr>
                                <td>$note_data</td>
                                <td>$created_date</td>
                                <td>
                                <a href="./deleteNote.php?note_id=$note_id&diagnosis_id=$diagnosis_id" class="diagnosis__CTA-delete">Delete</a>
                            </tr>

                        HTML;

                        }

                        ?>

                        </tbody>
                    </table>
                    <div class="form-group container">
                        <a href="./patientList.php" class="diagnosis__CTA-view">Cancel</a>
                        <a href="./patientList.php" class="diagnosis__CTA-delete">Back</a>
                    </div>
                </div>

            </div>

        </div>

        <!--Diagnosis about patient-->

        <!--Notes Notes about diagnosis-->





    </div>
</main>
</body>

</html>
