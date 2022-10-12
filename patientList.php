<?php



    require_once './connection.php';
    require_once './Includes/autoload.inc.php';
    require_once './varDump.php';

    //For security purposes the app won't allow a user to move to the next page if there are not Authorized
    if (session_start()) {

        $logged_user_name = ucfirst(strtolower( $_SESSION['user']['firstname']));
        $logged_user_surname = ucfirst(strtolower($_SESSION['user']['surname']));
        $logged_user_email = ucfirst(strtolower($_SESSION['user']['email']));

        $patients = [];
        if (!isset($_SESSION['user'])){
            header('location : localhost/clinicare/index.php');
            session_destroy();
        }else {

            try {

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

        }

    } else{

        header('location : localhost/clinicare/index.php');
        session_destroy();
    }

?>

<!doctype html>
<html lang="en">
<head>
    <?php  $title = "Patients";
    require_once 'htmlhead.php' ?>
</head>
<body>
    <header class="header">
        <nav class="header__navbar container">
            <div class="header__logo">
                <img src="./public/images/logo.svg" alt="">
            </div>
            <ul class="navbar__list">
                <li><a class="navbar__list-partient" href="#">Patients</a></li>
                <li><a class="navbar__list-add" href="./register_patient.php">Register a new patient</a></li>
            </ul>

            <a href="#">Contact IT support</a>
        </nav>
    </header>
    <main class="main">
        <section class = "admin-panel" >
            <div class="container">
                <h3>Administrator - <?php echo $logged_user_name." ". $logged_user_surname?> </h3>
                <form action="">
                    <div class="search-patient">
                        <input type="search" name="search-patient" id="search-patient" placeholder="search by ID of File Number...">
                        <button type="submit" id="search-btn">search</button>
                    </div>
                </form>
                <a class="logout-btn" id="logout-btn" href="logout.php">Logout</a>
            </div>
        </section>
        <?php

        if($patients) {
            echo <<< TABLEHEADER
            <table class="patients-table">
                <thead>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>SURNAME</th>
                    <th>PATIENT NUMBER</th>
                    <th>ACTIONS</th>
                </thead>
                <tbody>
            TABLEHEADER;

            foreach ($patients as $patient) {

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

            echo <<< CLOSETABLE
                </tbody>
                </table>
            CLOSETABLE;

        } else {

            echo "<h5>Welcome to clinicare management system you can now start adding patients to the system</h5>";

        }
    ?>
    </main>

    <?php include_once './Views/_footer.php'; ?>
</body>
</html>


