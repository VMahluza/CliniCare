
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get

try {

    /** @var TYPE_NAME $db */
    $select_stmt = $db->prepare("SELECT id, patientNumber,firstname, surname, created FROM patient WHERE id = :person_id;");


    $select_stmt->execute([':person_id' => $_GET['id']]);
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
$errMsg = ['title' => [], 'description' => []];

if (isset($_REQUEST['add_diagnosis'])){

    if (isset($_POST)){

        if (!isset($_POST['title']) || $_POST['title'] == "" || $_POST['title'] == null){

            $errMsg['title'][] = "Title is required for Diagnosis";
        }
        if (!isset($_POST['description']) || $_POST['description'] == "" || $_POST['description'] == null){

            $errMsg['description'][] = "Description is required for Diagnosis";

        }

    }

        varDumber(empty($errMsg));
    varDumber($errMsg);

    if (empty($errMsg['title']) || empty($errMsg['description'])){
        try {

            $insert_stmt = $db->prepare("INSERT INTO diagnosis (person_id, title, description, date)
                                            VALUES (:person_id, :title, :description, :date)");

            $date = new DateTime();
            $date = $date->format('y-m-d H:i:s');

            $insert = $insert_stmt->execute(
                    [
                        ':person_id' => $patient->getId(),
                        ':title' => $_POST['title'],
                        ':description' => $_POST['description'],
                        ':date' => $date
                    ]
            );

            if ($insert === true) {
                header("location:ViewPatient.php?id=" . $patient->getId());
                exit;
            }
        }catch (PDOException $e){

        }
    }

}
?>

<!doctype html>
<html lang="en">
<head>
    <?php $title = " Patient | " . $patient->getPatientNumber();
    require_once 'htmlhead.php' ?>
</head>
<body>

</body>
</html>

<div class="container">

    <div class="mb-3">
        <form action="./AddDiagnosis.php" method="post">


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
    </div>


    <form action="./AddDiagnosis.php?id=<?php echo $patient->getId()?>" method="post">

        <div class="container">
        <h5>Diagnosis Information</h5>


        <?php

            if (isset($errMsg['title'])){

                foreach ($errMsg['title'] as $error)
                    echo "<p class='alert-danger'>" . $error . "</p>";

            }
            if (isset($errMsg['description'])){

                foreach ($errMsg['description'] as $error)
                    echo "<p class='alert-danger'>" . $error . "</p>";

            }

        ?>

        <div class="mb-3">
            <input type="text" name="title" class="form-control" placeholder="Title">
            </div




            <div class="mb-3">
                <input type="text" name="description" class="form-control" placeholder="Description">
            </div>

        </div>

        <br><br>
        <button type="submit" name="add_diagnosis" class="btn btn-primary">Add Diagnosis</button>

    </form>

    <a href="./patientList.php" class="btn btn-primary">Cancel</a>
</div>
