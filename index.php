<?php

    require_once "./connection.php";

    session_start();

    $user = null;

    if (isset($_REQUEST['login_btn'])){

        $email =  filter_var(strtoupper($_REQUEST["email"]),FILTER_SANITIZE_EMAIL );

        $password =  strip_tags($_REQUEST["password"]);

        if (empty($email)){
            $errorMsg [2][] = 'email field is required';
        }
        if (empty($password)){
            $errorMsg [3][] = 'password field is required';
        }

        if (empty($errorMsg)){

            /** @var TYPE_NAME $db */
            $select_stmt = $db->prepare("SELECT * FROM user WHERE email = :email OR password = :password LIMIT 1");
            $select_stmt->execute([':email' => $email, ':password' => $password]);

            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($row['password']) && isset($row['email'])  && $select_stmt->rowCount() > 0){

                if ($email === $row['email'] && password_verify($password, $row['password'])) {

                    try {

                            //if the user registers here we want them to click something to confirm
                            $_SESSION['user']['id'] = $row['id'];
                            $_SESSION['user']['firstname'] = $row['firstname'];
                            $_SESSION['user']['surname'] = $row['surname'];
                            $_SESSION['user']['email'] =  $row['email'];
                            $_SESSION['user']['created'] =  $row['created'];
                            $_SESSION['user']['role_id'] = $row['role_id'];

                        if (isset($_SESSION['user'])){
                            header("Location: patientList.php");
                            exit;
                        }else{
                            $errorMsg [2][] = 'Wrong email or password <a class="register" href="index.php">Reset password</a>';
                        }

                    }catch (PDOException $E){

                        echo '<br>ERROR!!'.$E->getMessage();
                    }

                }else{

                    $errorMsg [2][] = 'Wrong email or password <a class="register" href="index.php">Reset password</a>';


                }
            }
        }

    }

?>

<html lang="en">
    <?php $title = '| Login';
    require_once 'htmlhead.php'?>
<body>
<div class="container">

    <?php
        if(isset($errorMsg[2])){
            foreach ($errorMsg[2] as $error){
                echo "<p class='small text-danger'>".$error."</p>";
            }
        }
    ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="jane@doe.com">
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
            <input type="password" name="password" class="form-control" placeholder="">
        </div>
        <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
    </form>
    No Account? <a class="register" href="register.php">Register Instead</a>
</div>
</body>

</html>