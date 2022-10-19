
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get

$patient = null;

if ($_GET != null){

    $id = $_GET['id'];

    /** @var TYPE_NAME $db */

    $patient = viewPatientById($db, $id);

    $create = date_format(date_create($patient->getCreated()) , 'd M Y H:i:s');

    if (isset($_REQUEST['save_btn'])){

        //We will user filter_var to make sure that correct data has been entered

        $firstname = filter_var(strtoupper($_REQUEST['firstname']), FILTER_SANITIZE_STRING);
        $surname =  filter_var(strtoupper($_REQUEST['surname']), FILTER_SANITIZE_STRING);

        $errorMsg = null;
        //Error checking
        if (empty($firstname)){
            $errorMsg ['firstname'][] = 'First name field is required';

        }
        if (empty($surname)){
            $errorMsg ['surname'][] = 'Last/Surname name field is required';
        }

        if (empty($errorMsg)){

            //If the patient is updated the we redirect the user to patientList.php
            $updated = updatePatient($db, $patient->getId(), $firstname ,$surname);

            if ($patient){
                header("location:patientList.php");
            }


        }


    }

}




?>

<!doctype html>
<html lang="en">
<head>
    <?php $title = "New Patient";
    require_once './htmlhead.php' ?>
</head>
<body>

</body>
</html>

<div class="diagnosis-container">

    <form  action="./update_patient.php?id=<?php echo $patient->getId()?>" method="post">

        <div class="form-group container">
            <label for="password" class="form-label">Patient Number</label>
            <input type="text" class="form-group__input" name="patientNumber" value="<?php echo ucwords(strtolower($patient->getPatientNumber()))?>" readonly>
        </div>

        <?php
        if(isset($errorMsg['firstname'])){
            foreach ($errorMsg['firstname'] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
        ?>
        <div class="form-group container">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-group__input" name="firstname" class="form-control" value="<?php echo ucwords(strtolower($patient->getFirstName()))?>" required>
        </div>

        <?php
        if(isset($errorMsg['surname'])){
            foreach ($errorMsg['surname'] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
        ?>
        <div class="form-group container">
            <label for="surname" class="form-label">Last Name</label>
            <input type="text" name="surname" class="form-group__input" value="<?php echo ucwords(strtolower($patient->getSurname()))?>" required>
        </div>
        <div class="form-group container">
            <button type="submit" name="save_btn" class="diagnosis__CTA-update">Save</button>
            <a class="diagnosis__CTA-view" href="./update_patient.php?id=<?php echo $patient->getId()?>">Cancel</a>
            <a class="diagnosis__CTA-delete" href="./patientList.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
