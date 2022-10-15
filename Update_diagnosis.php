<?php

?>
<?php

require_once './connection.php';
require_once './Includes/autoload.inc.php';
require_once './varDump.php';


if (session_start()) {

    $logged_user_name = ucfirst(strtolower($_SESSION['user']['firstname']));
    $logged_user_surname = ucfirst(strtolower($_SESSION['user']['surname']));
    $logged_user_email = ucfirst(strtolower($_SESSION['user']['email']));

}else {

    header("location:login.php");

}

if ($_GET != null){

    $id = $_GET['id'];
    $Diagnosis_id = $_GET['diagnosis_id'];

    /** @var TYPE_NAME $db */
    $patient = viewPatientById($db, $id);

    $Diagnosis = $diagnosis = viewDiagnosisById($db, $Diagnosis_id);

    $create = date_format(date_create($patient->getCreated()) , 'd M Y H:i:s');

}
if (isset($_REQUEST['save_btn'])){

    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];

    $updated =  updateDiagnosis($db, $Diagnosis->getDiagnosisId(), $title ,$description);
    if ($updated) {

        $patient_ID = $Diagnosis->getPersonId();
        header("location:ViewPatient.php?id=$patient_ID");

    }

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
    <div class="patient container">
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
            <div class="diagnosis-container">
                <form action="./Update_diagnosis.php?id=<?php echo $diagnosis->getPersonId()?>>&diagnosis_id=<?php echo $Diagnosis_id; ?>" method="post">
                    <div class="form-group container">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-group__input" value="<?php echo $Diagnosis->getTitle()?>" >
                    </div>
                    <div class="form-group container">
                        <label for="title" class="form-label">Description</label>
                        <input type="text" name="description" class="form-group__input" value="<?php echo $Diagnosis->getDescription()?>" >
                    </div>

                    <button type="submit" name="save_btn" class="btn btn-primary">Save</button>
                    <div class="form-group container" style="display: flex;">
                        <a href="./Update_diagnosis.php?id=<?php echo $diagnosis->getPersonId()?>>&diagnosis_id=<?php echo $Diagnosis_id; ?>" class="">Cancel</a>
                        <a href="./ViewPatient.php?id=<?php echo $Diagnosis->getPersonId()?>" class="">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


</main>
<?php require_once "./Views/_footer.php" ?>
</body>

</html>


