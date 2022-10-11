
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get
if (isset($_REQUEST['register_btn'])){

    //We will user filter_var to make sure that correct data has been entered

    $firstname = filter_var(strtoupper($_REQUEST['firstname']), FILTER_SANITIZE_STRING);

    varDumber($firstname);
    $surname =  filter_var(strtoupper($_REQUEST['surname']), FILTER_SANITIZE_STRING);
    varDumber($surname);
    $patientNumber = filter_var(strtoupper($_REQUEST['patientNumber']), FILTER_SANITIZE_STRING);
    varDumber($patientNumber);

    $errorMsg;
    //Error checking
    if (empty($firstname)){
        $errorMsg [0][] = 'First name field is required';

    }
    if (empty($surname)){
        $errorMsg [1][] = 'Last/Surname name field is required';
    }
    if (empty($patientNumber)){
        $errorMsg [2][] = 'patient number field is required';
    }

    varDumber($errorMsg);

    if (empty($errorMsg)){
        try {

            $select_stmt = $db->prepare("SELECT patientNumber FROM patient WHERE patientNumber = :patientNumber");
            $select_stmt->execute([':patientNumber' => $patientNumber]);

            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

                //We want to also know when was the user created
                $created = new DateTime();

                $created = $created->format('y-m-d H:i:s');
                $insert_stmt = $db->prepare("INSERT INTO patient (firstname, surname, patientNumber, created) 
                                                            VALUES (:firstname, :surname, :patientNumber, :created)");

                //Redirecting the user to the page they are supposed to be after registering
                $insert = $insert_stmt->execute(
                    [
                        ':firstname' => $firstname,
                        ':surname' => $surname,
                        ':created' => $created,
                        ':patientNumber' => $patientNumber
                    ]
                );

                if($insert === true){

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



    <form action="./register_patient.php" method="post">


        <?php
        if(isset($errorMsg[0])){
            foreach ($errorMsg[0] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
        ?>

        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" placeholder="Victor">
        </div>


        <div class="mb-3">
            <label for="surname" class="form-label">Last Name</label>
            <input type="text" name="surname" class="form-control" placeholder="Mahluza">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Patient Number</label>
            <input type="text" name="patientNumber" class="form-control">
        </div>

        <div class="mb-3" style="display: flex">
            <label for="repassword" class="form-label">Patient has initial diagnosis ?</label>
            <select class="form-select form-select-sm" name="role" id="role">
                <option value="YES">Yes</option>
                <option value="NO">No</option>
            </select>
        </div>

        <button type="submit" name="register_btn" class="btn btn-primary">Register Patient</button>
    </form>
</div>
