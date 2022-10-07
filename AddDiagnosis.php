
<?php
require_once './varDump.php';
require_once './connection.php';
require_once './Includes/autoload.inc.php';

//Controlling what happens when a user submitt a form
//Request has both post and get

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

    <div class="mb-3">
        <H4>Patient Full Name : Nothando Madonsela</H4>
        <H4>Patient Number    : 123456789</H4>
    </div>


    <form action="./register_patient.php" method="post">

        <div class="container">
        <h5>Diagnosis Information</h5>


        <div class="mb-3">
            <input type="text" name="firstname" class="form-control" placeholder="Title">
            </div

            <div class="mb-3">
                <input type="text" name="surname" class="form-control" placeholder="Description">
            </div>

            <div class="container">
                <h6>Initial Notes</h6>
                <div class="mb-3">
                    <input type="text" name="surname" class="form-control" placeholder="Description">
                </div>
            </div>
        </div>

        <br><br>
        <button type="submit" name="register_btn" class="btn btn-primary">Add Diagnosis</button>

    </form>

    <a href="./patientList.php" class="btn btn-primary">Cancel</a>
</div>
