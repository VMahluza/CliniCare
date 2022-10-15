
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';


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
<div class="container">

<!--Patient-->
    <form action="" method="post">

        <div class="mb-3" style="display: flex">
            <label for="firstname" class="form-label">Patient Number</label>
            <input type="number" disabled name="firstname" class="form-control" value="<?php echo $patient->getPatientNumber()?>" >
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Name</label>
            <input type="text" disabled name="firstname" class="form-control" value="<?php echo ucwords(strtolower($patient->getFirstName()))?>">
        </div>

        <div class="mb-3">
            <label for="firstname" class="form-label">Surname</label>
            <input type="text" disabled name="firstname" class="form-control" value="<?php echo ucwords(strtolower($patient->getSurname()))?>">
        </div>

        <div class="mb-3">
            <label for="firstname" class="form-label">Admision date</label>
            <input type="text" disabled name="firstname" class="form-control" value="<?php echo $patient->getCreated() ?>">
        </div>

    </form>
<!--Diagnosis about patient-->
    <form action="./register_patient.php" method="post">
        <div class="container">
            <h5>Diagnosis Information</h5>


            <div class="mb-3">
                <input type="text" disabled name="firstname" class="form-control" value="<?php echo $diagnosis->getTitle()?>" placeholder="Title">
            </div

            <div class="mb-3">
                <input type="text" disabled name="surname" class="form-control" value="<?php echo $diagnosis->getDescription()?>" placeholder="Description">
            </div>
            <div class="mb-3">
                <input type="text" disabled name="surname" class="form-control" value="<?php echo $diagnosis->getDate() ?>" placeholder="Description">
            </div>
        </div>

        <br><br>
    </form>
<!--Notes Notes about diagnosis-->

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
            <div class="mb-3">
                <input type="text" name="note_discription" class="form-control"  placeholder="Type patient Notes Here...">
            </div>
            <button type="submit" name="addnote_btn" class="btn btn-primary">Add Note</button>
        </div>
    </form>

    <table class = "table">
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
                                <td style="display: flex; padding: 10px">
                                <a href="./deleteNote.php?note_id=$note_id&diagnosis_id=$diagnosis_id" class = "btn btn-danger">Delete</a>
                            </tr>

                        HTML;

        }

        ?>

        </tbody>
    </table>

    <a href="./patientList.php" class="btn btn-primary">Cancel</a>
    <a href="./patientList.php" class="btn btn-secondary">Back</a>
</div>
</body>

</html>
