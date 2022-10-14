
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get



if ($_GET != null){

    $id = $_GET['id'];

    /** @var TYPE_NAME $db */
    $select_stmt = $db->prepare("SELECT * FROM patient WHERE id = :id;");

    $select_stmt->execute([':id' => $id]);

    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


    $patient = new Patient(

        $row['id'],
        $row['patientNumber'],
        $row['firstname'],
        $row['surname'],
        $row['created']

    );

    $create = date_format(date_create($patient->getCreated()) , 'd M Y H:i:s');

}


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
        try {

            //UPDATE Customers
            //SET ContactName='Alfred Schmidt', City='Hamburg';
            $select_stmt = $db->prepare("UPDATE patient SET firstname = :firstname, surname=:surname;");

            $update = $select_stmt->execute([':firstname' => $firstname,
                ':surname'=>$surname]);

            if($update === true){

                //if the user registers here we want them to click something to confirm
                header("Location: patientList.php");
                exit;
            }

        }catch (PDOException $E){
            $pdoErro = $E->getMessage();
            echo "We have an error due to : $pdoErro";
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

<div class="container">



    <form action="./update_patient.php" method="post">

        <div class="mb-3">
            <label for="password" class="form-label">Patient Number</label>
            <input type="text" name="patientNumber" value="<?php echo ucwords(strtolower($patient->getPatientNumber()))?>" readonly>
        </div>

        <?php
        if(isset($errorMsg['firstname'])){
            foreach ($errorMsg['firstname'] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
        ?>
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo ucwords(strtolower($patient->getFirstName()))?>" required>
        </div>

        <?php
        if(isset($errorMsg['surname'])){
            foreach ($errorMsg['surname'] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
        ?>
        <div class="mb-3">
            <label for="surname" class="form-label">Last Name</label>
            <input type="text" name="surname" class="form-control" value="<?php echo ucwords(strtolower($patient->getSurname()))?>" required>
        </div>
        
        <button type="submit" name="save_btn" class="btn btn-primary">Save</button>
        <a href="./update_patient.php?id=<?php echo $patient->getId()?>">Cancel</a>
        <a href="./patientList.php" class="btn btn-secondary">Back</a>
    </form>
</div>
