<?php
    require_once './connection.php';
    require_once './Includes/autoload.inc.php';

    $user = null;
    //If the the user is done registering we redirect the user to the Login page
    session_start();
    if (isset($_SESSION['user'])) { header("location:index.php" );}

    //Controlling what happens when a user submitt a form
    //Request has both post and get
    if (isset($_REQUEST['register_btn'])){

        //We will user filter_var to make sure that correct data has been entered

        $firstname = filter_var(strtoupper($_REQUEST['firstname']), FILTER_SANITIZE_STRING);
        $surname =  filter_var(strtoupper($_REQUEST['surname']), FILTER_SANITIZE_STRING);
        $email =  filter_var(strtoupper($_REQUEST["email"]),FILTER_SANITIZE_EMAIL );
        $password =  strip_tags($_REQUEST["password"]);//strip tags making sure that no html code is writed in the password
        $role = $_REQUEST["role"];

        $role_id = match($role){
            'DR' => User::DR,
            'ADMIN' => User::ADMIN
        };

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

                        $errorMsg [2][] = 'email already exist, log in instead <a class="register" href="index.php">Login Instead</a>';
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
                            header("Location: index.php?msg=".urlencode('Click the varification email'));
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
<div class="container">
    <form action="register.php" method="post">

        <?php
            if(isset($errorMsg[0])){
                foreach ($errorMsg[0] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>

        <div class="mb-3">
            <label for="firstname" class="form-label">Name</label>
            <input type="text" name="firstname" class="form-control" placeholder="Victor">
        </div>

        <?php
            if(isset($errorMsg[1])){
                foreach ($errorMsg[1] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>

        <div class="mb-3">
            <label for="surname" class="form-label">Name</label>
            <input type="text" name="surname" class="form-control" placeholder="Mahluza">
        </div>

        <?php
            if(isset($errorMsg[2])){
                foreach ($errorMsg[2] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="email@mail.com">
        </div>

        <?php
            if(isset($errorMsg[3])){
                foreach ($errorMsg[3] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password">
        </div>
        <?php
            if(isset($errorMsg[4])){
                foreach ($errorMsg[4] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>
        <div class="mb-3">
            <label for="repassword" class="form-label">Repeat password</label>
            <input type="password" name="repassword" class="form-control" placeholder="re-password">
        </div>
        <div class="mb-3">
            <label for="repassword" class="form-label">Role ?</label>
            <select class="form-select form-select-sm" name="role" id="role">
                <option value="DR">Dr</option>
                <option value="ADMIN">Admin</option>
            </select>
        </div>
        <button type="submit" name="register_btn" class="btn btn-primary">Register Account</button>
    </form>
    Already Have an Account? <a class="register" href="index.php">Login Instead</a>
</div>
</body>

</html>