<?php

    require_once './connection.php';
    require_once './Includes/autoload.inc.php';
    require_once './varDump.php';



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
    ?>

<html lang="en">
<head>
    <?php $title = " Patient | " . $patient->getPatientNumber();
    require_once 'htmlhead.php' ?>
</head>

<body>
<div class="container">
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
            <input type="text" disabled name="firstname" class="form-control" value="<?php echo $create ?>">
        </div>

        <?php require_once './DiagnosisList.php'?>

        <button type="submit" name="register_btn" class="btn btn-primary">Save</button>
    </form>

    <a href="./patientList.php" class="btn btn-primary">Cancel</a>
    <a href="./patientList.php" class="btn btn-secondary">Back</a>
</div>
</body>

</html>

