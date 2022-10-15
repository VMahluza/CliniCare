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
    $Diagnosis_id = $_GET['Diagnosis_id'];

    /** @var TYPE_NAME $db */

    $patient = viewPatientById($db, $id);

    $create = date_format(date_create($patient->getCreated()) , 'd M Y H:i:s');

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




    </div>

    <a href="./patientList.php" class="btn btn-primary">Cancel</a>
    <a href="./patientList.php" class="btn btn-secondary">Back</a>
</main>
</body>

</html>


