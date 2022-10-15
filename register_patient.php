
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get
if (isset($_REQUEST['register_btn'])){

    //We will user filter_var to make sure that correct data has been entered

    $firstname = filter_var(strtoupper($_REQUEST['firstname']), FILTER_SANITIZE_STRING);

    $surname =  filter_var(strtoupper($_REQUEST['surname']), FILTER_SANITIZE_STRING);
    $patientNumber = filter_var(strtoupper($_REQUEST['patientNumber']), FILTER_SANITIZE_STRING);

    $errorMsg = null;
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
    require_once "htmlhead.php" ?>
</head>
<body>

</body>
</html>

<main class="container main">

    <div class="split-screen">
        <form action="./register_patient.php" method="post" class="split-screen__form">
            <h1 class="section-title">Register a new patient</h1>
            <?php
            if(isset($errorMsg[0])){
                foreach ($errorMsg[0] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
            ?>
    
            <div class="form-group">
                <label for="firstname" class="">First Name</label>
                <input type="text" name="firstname" class="form-group__input" placeholder="">
            </div>
    
    
            <div class="form-group">
                <label for="surname" class="">Last Name</label>
                <input type="text" name="surname" class="form-group__input" placeholder="">
            </div>
    
            <div class="form-group">
                <label for="password" class="">Patient Number</label>
                <input type="text" name="patientNumber" class="form-group__input">
            </div>
    
            <div class="form-group">
                <label for="repassword" class="">Patient has initial diagnosis ?</label>
                <select class="role-selection" name="role" id="role">
                    <option value="YES">Yes</option>
                    <option value="NO">No</option>
                </select>
            </div>
            <button type="submit" name="register_btn" class="btn-signup button">Register Patient</button>
            <a href="./patientList.php" class="back-btn">Back</a>
        </form>
        
        <div class="split-screen__img">
            <img src="./public/images/doctors.svg" alt="">
        </div>
    </div>

</main>

<?php require_once './views/_footer.php' ?>
