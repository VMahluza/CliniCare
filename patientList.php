<?php

    session_start();

    require_once './connection.php';
    require_once './Includes/autoload.inc.php';
    require_once './varDump.php';

    $patients = [];

try {


//    $select_stmt->execute([':email' => $email]);
//
//    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    /** @var TYPE_NAME $db */
    $select_stmt = $db->prepare("SELECT id, patientNumber,firstname, surname, created FROM patient;");


    $select_stmt->execute();
    $rows = $select_stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($rows as $row){

        $patients[] = new Patient(

                $row['id'],
                $row['patientNumber'],
                $row['firstname'],
                $row['surname'],
                $row['created']
        );
    }
}catch (PDOException $E){
    $pdoErro = $E->getMessage();
    echo "We have an error due to : $pdoErro";
}

function deletePatient($id){

    varDumber($id);

}

?>

<!doctype html>
<html lang="en">
<head>
    <?php  $title = "Patients"; require_once 'htmlhead.php'?>

</head>
<body>

    <div class="container">

        <div class = "mb-3" >
            <form action="">
                <div class="mb-3" style="display: flex">
                    <label for="firstname" class="form-label-sm">Search by Patient Number </label>
                    <input type="text" name="firstname" class="form-control" placeholder="Victor">
                    <a class="btn btn-primary">Look</a>
                </div>
            </form>
            <a class="container btn btn-primary" style="float: right" href="./">Register a new patient</a>
        </div>
        <table class = "table">
            <thead>
                <th>ID</th>
                <th>NAME</th>
                <th>SURNAME</th>
                <th>PATIENT NUMBER</th>
                <th>ACTIONS</th>
            </thead>
            <tbody>

                <?php

                    foreach ($patients as $patient){

                        $id = $patient->getId();
                        $name = ucwords(strtolower($patient->getFirstName()));
                        $surname = ucwords(strtolower($patient->getSurname()));
                        $patientNumber = $patient->getPatientNumber();

                        echo <<< HTML
                                
                            <tr>
                                <td>$id</td>
                                <td>$name</td>
                                <td>$surname</td>
                                <td>$patientNumber</td>
                                <td style="display: flex; padding: 10px">
                                    <a style="margin: 5px" class = "btn btn-primary" href="./ViewPatient.php?id=$id">View</a>
                                    <a style="margin: 5px" class = "btn btn-secondary" href="./UpdatePatient.php?id=$id">Update</a>
                                    <a style="margin: 5px" class = "btn btn-danger" href="./deletePatient.php?id=$id">Delete</a>
                                </td>
                            </tr>
                        HTML;
                    }

                ?>

            </tbody>
        </table>
    </div>

    <a class = 'btn btn-secondary' href="logout.php">Logout</a>

</body>
</html>


