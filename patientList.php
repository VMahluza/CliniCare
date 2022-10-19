<?php



require_once './connection.php';
require_once './Includes/autoload.inc.php';
require_once './varDump.php';

//For security purposes the app won't allow a user to move to the next page if there are not Authorized
if (session_start()) {

    $logged_user_name = ucfirst(strtolower( $_SESSION['user']['firstname']));
    $logged_user_surname = ucfirst(strtolower($_SESSION['user']['surname']));
    $logged_user_email = ucfirst(strtolower($_SESSION['user']['email']));

    if ($_SESSION['user'] == null){
        header('location : localhost/clinicare/login.php');
        session_destroy();
    }else {

        /** @var TYPE_NAME $db */
        $patients = viewPatients($db);

    }

} else{

    header('location : localhost/clinicare/login.php');
    session_destroy();
}
$search = '' ;
if (isset($_REQUEST['search-patient'])){
    $patients = null;
    $patients = searchPatients($db , $_POST['search-patient']);

}

?>

<!doctype html>
<html lang="en">
<head>
    <?php  $title = "Patients";
    require_once 'htmlhead.php' ?>
</head>
<body>
<?php require_once "./Views/_header.php";?>
<main>
    <section class = "admin-panel" >

        <div class="container">
            <form action="./patientList.php" method="post">
                <div class="search-patient">
                    <input type="search" name="search-patient" id="search-patient" placeholder="search...">
                    <button type="submit" id="search-btn">search</button>
                </div>

            </form>
            <a href="./register_patient.php" class="navbar__list-add">New Patient</a>
        </div>
    </section>
    <div class="patient-list-table">
        <?php

        if($patients) {
            echo <<< TABLEHEADER
                <table class="patients-table">
                    <thead>
                        <th>NAME</th>
                        <th>SURNAME</th>
                        <th>PATIENT NUMBER</th>
                        <th>ACTIONS</th>
                    </thead>
                    <tbody>
                TABLEHEADER;
            $count = 0;
            foreach ($patients as $patient) {

                $id = $patient->getId();
                $name = ucwords(strtolower($patient->getFirstName()));
                $surname = ucwords(strtolower($patient->getSurname()));
                $patientNumber = $patient->getPatientNumber();

                echo <<< HTML
                        <tr>
                            <td>$name</td>
                            <td>$surname</td>
                            <td>$patientNumber</td>
                            <td>
                                <a style="border: 0.5px solid var(--light-blue)" class = "diagnosis__CTA-view" href="./ViewPatient.php?id=$id">View</a>
                                <a class = "diagnosis__CTA-update" href="./update_patient.php?id=$id">Update</a>
                                <a class = "diagnosis__CTA-delete" href="./deletePatient.php?id=$id">Delete</a>                            </td>
                        </tr>
                    HTML;
                $count++;

            }

            echo <<< CLOSETABLE
                    </tbody>
                    </table>
                CLOSETABLE;
            echo "<p>Rows - $count found</p>";
        } else {

            echo "<h5>Welcome to clinicare management system you can now start adding patients to the system</h5>";

        }
        ?>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php include_once './Views/_footer.php'; ?>
</body>
</html>


