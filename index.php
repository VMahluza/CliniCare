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
    require_once 'htmlhead.php' ?>
<body>
<main class="main container">

    <!-- Some cool animation before the index page come into view 😎😎😎-->
    <div class="onload-animation-screen">
        <div class="logo-animation">
            <div class="left-c">
                <img src="public/images/logo-parts/left-c.svg" alt="">
            </div>
            <div class="clini-care-text">
                <img class="clini" src="public/images/logo-parts/CLINI.svg" alt="">
                <img class="care" src="public/images/logo-parts/CARE.svg" alt="">
            </div>
            <div class="right-c">
                <img src="public/images/logo-parts/right-c.svg" alt="">
            </div>
        </div>
        <h1 class="slogan">Health Care For All</h1>
    </div>

    <div class="split-screen">
        <div class="split-screen__img">
            <img src="../CliniCare/public/images/doctor.svg" alt="doctor photo">

        </div>
        <?php
            if(isset($errorMsg[2])){
                foreach ($errorMsg[2] as $error){
                    echo "<p class='small text-danger'>".$error."</p>";
                }
            }
        ?>
        <form class="split-screen__form" action="index.php" method="post">

            <h1 class="section-title">Login to your account</h1>
            <p class="section-text">or <a class="link-pink" href="register.php">signup here</a> to create an account</p>


            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input class="form-group__input" type="email" name="email"  placeholder="">
            </div>
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
                    <input class="form-group__input" type="password" name="password" id="password">
                    <img class="password-show" src="./public/images/eye.svg" alt="show password button" id="show-password">
                </div>
            </div>

            <button class="button btn-login" type="submit" name="login_btn" class="btn btn-primary">Login</button>
        </form>
    </div>
</main>
<?php include_once './views/_footer.php'; ?>
</body>

</html>