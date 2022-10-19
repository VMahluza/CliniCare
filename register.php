<?php

require_once './connection.php';
require_once './Includes/autoload.inc.php';

//$user = null;
//If the the user is done registering we redirect the user to the Login page
session_start();
if (isset($_SESSION['user'])) { header("location:login.php" );}

//Controlling what happens when a user submitt a form
//Request has both post and get
if (isset($_REQUEST['register_btn'])){

    //We will user filter_var to make sure that correct data has been entered
    $firstname = filter_var(strtoupper($_REQUEST['firstname']), FILTER_SANITIZE_STRING);
    $surname =  filter_var(strtoupper($_REQUEST['surname']), FILTER_SANITIZE_STRING);
    $email =  filter_var(strtoupper($_REQUEST["email"]),FILTER_SANITIZE_EMAIL );
    $password =  strip_tags($_REQUEST["password"]);//strip tags making sure that no html code is writed in the password
    $role = $_REQUEST["role"];

    //This only support new php versions
    // $role_id = match($role){
    //     'DR' => User::DR,
    //     'ADMIN' => User::ADMIN
    // };
    var_dump($_REQUEST);
    $role_id = 0;

    switch($role){

        case "":
            $role_id = 0;
            break;

        case "DR":
            $role_id = 1;
            break;
        case "ADMIN":
            $role_id = 2;
            break;

    }

    //Error checking
    if (empty($firstname)){
        $errorMsg [0][] = 'First name field is required';
    }
    if (empty($surname)){
        $errorMsg [1][] = 'Last/Surname name field is required';
    }
    if (empty($email)){
        $errorMsg [2][] = 'email field is required';
    }
    if (empty($password)){
        $errorMsg [3][] = 'password field is required';
    }
    if (strlen($password) < 6){
        $errorMsg [3][] = 'Password must have atleast 6 characters';
    }
    if ($password != $_REQUEST["repassword"]){
        $errorMsg[4][] = 'Password mismatch !';
    }

    if (empty($errorMsg)){
        try {

            $select_stmt = $db->prepare("SELECT firstname, email FROM user WHERE email = :email");
            $select_stmt->execute([':email' => $email]);

            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


            if ($row['email']  === $email && isset($row['email'])){

                $errorMsg [2][] = 'email already exist, log in instead <a class="register" href="login.php">Login Instead</a>';
                echo "SEKJEKJRWKRJKWR";
            }else {

                echo "SEKJEKJRWKRJKWR";
                //We do not want an accesseble password to our app security is vital
                $hash_password = password_hash($password, PASSWORD_DEFAULT);

                //We want to also know when was the user created
                $created = new DateTime();

                $created = $created->format('y-m-d H:i:s');
                //INSERT INTO `user` (`id`, `firstname`, `surname`, `email`, `password`, `role_id`, `created`)
                //            VALUES (NULL, 'Admin', 'Mahluza', 'admin@com', 'admin', '1', '2022-10-02 14:10:05.000000')
                $insert_stmt = $db->prepare("INSERT INTO user (firstname, surname, email, password, role_id, created) 
                                                            VALUES (:firstname, :surname, :email, :password, :role_id, :created)");

                //Redirecting the user to the page they are supposed to be after registering
                $insert = $insert_stmt->execute(
                    [
                        ':firstname' => $firstname,
                        ':surname' => $surname,
                        ':email' => $email,
                        ':password' => $hash_password,
                        ':role_id' => $role_id,
                        ':created' => $created
                    ]
                );

                if($insert === true){

                    //if the user registers here we want them to click something to confirm
                    header("Location: login.php?msg=".urlencode('Click the varification email'));
                    exit;
                }

            }


        }catch (PDOException $E){
            $pdoErro = $E->getMessage();
            echo "We have an error due to : $pdoErro";
        }

    }

    //After every validation we send this data to the user object
    $user = new User($firstname, $surname, $email, $password, $role_id);

}

?>
<html lang="en">

<head>
    <?php $title = ' Register';
    require_once 'htmlhead.php' ?>
</head>

<body>

<main class="main container">

    <div class="split-screen">
        <div class="split-screen__img">
            <img src="./public/images/medicine.svg" alt="doctor photo">
        </div>
        <form class="split-screen__form" action="register.php" method="post">

            <h1 class="section-title">Restration</h1>
            <p class="section-text">Create an account or <a class="link-blue" href="login.php">login here</a> if you already have an account</p>

            <div class="form-grid">
                <?php
                if(isset($errorMsg[0])){
                    foreach ($errorMsg[0] as $error){
                        echo "<p class='small text-danger'>".$error."</p>";
                    }
                }
                ?>

                <div class="form-group">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-group__input">
                </div>

                <?php
                if(isset($errorMsg[1])){
                    foreach ($errorMsg[1] as $error){
                        echo "<p class='small text-danger'>".$error."</p>";
                    }
                }
                ?>

                <div class="form-group">
                    <label for="surname" class="form-label">Last Name</label>
                    <input type="text" name="surname" class="form-group__input" >
                </div>

                <?php
                if(isset($errorMsg[2])){
                    foreach ($errorMsg[2] as $error){
                        echo "<p class='small text-danger'>".$error."</p>";
                    }
                }
                ?>

                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-group__input" required>
                </div>
                <!-- PASSWORD-->
                <?php
                if(isset($errorMsg[3])){
                    foreach ($errorMsg[3] as $error){
                        echo "<p class='small text-danger'>".$error."</p>";
                    }
                }
                ?>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password">
                        <input type="password" name="password" class="form-group__input" id="password" required>
                        <img class="password-show" src="./public/images/eye.svg" alt="show password button" id="show-password">
                    </div>
                </div>
                <!--                REPEAT PASSWORD-->
                <?php
                if(isset($errorMsg[4])){
                    foreach ($errorMsg[4] as $error){
                        echo "<p class='small text-danger'>".$error."</p>";
                    }
                }
                ?>
                <div class="form-group">
                    <label for="repassword">Repeat password</label>
                    <div class="password">
                        <input type="password" name="repassword" class="form-group__input" id="repeat-password"  required>
                        <img class="password-show" src="./public/images/eye.svg" alt="show password button" id="show-repeat-password">
                    </div>
                </div>
                <!--                select Role-->
                <div class="form-group">
                    <label for="repassword" class="form-label">Select Role</label>
                    <select class="role-selection" name="role" id="role">
                        <option value="" disabled>Select your role</option>
                        <option value="DR">Doctor</option>
                        <option value="ADMIN">Administrator</option>
                    </select>
                </div>
                <!--Not impplemented-->
                <div class="form-group">
                    <label for="privacy-agreement">
                        <input type="checkbox" name="privacy-agreement" id="privacy-agreement" required>
                        I agree to the <a class="link-pink" href="#">privacy policy</a> of CliniCare
                    </label>
                </div>
            </div>
            <button type="submit" name="register_btn" class="button btn-signup">Register Account</button>
        </form>
    </div>

</main>
<?php include_once './views/_footer.php'; ?>
</body>

</html>