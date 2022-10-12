<?php include_once './_header.php'; ?>

<main class="main container">
    
    <div class="split-screen">
        <div class="split-screen__img">
            <img src="../public/images/medicine.svg" alt="doctor photo">

        </div>
        <form action="" class="split-screen__form" method="POST">
            <h1 class="section-title">Restration</h1>
            <p class="section-text">Create an account or <a class="link-blue" href="../index.php">login here</a> if you already have an account</p>
            <div class="form-grid">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input class="form-group__input" type="text" name="firstname" id="firstname" required autofocus>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input class="form-group__input" type="text" name="lastname" id="lastname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-group__input" type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="email">Select Role</label>
                    <select name="role" id="role" class="role-selection" required>
                        <option value="Select your role..." selected disabled></option>
                        <option value="admin">Administrator</option>
                        <option value="doctor">Doctor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password">
                        <input class="form-group__input" type="password" name="password" id="password" required>
                        <img src="../public/images/eye.svg" alt="show password" class="password-show" id="show-password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="repeat-password">Repeat Password</label>
                    <div class="password">
                        <input class="form-group__input" type="password" name="repeat-password" id="repeat-password" required>
                        <img src="../public/images/eye.svg" alt="show password" class="password-show" id="show-repeat-password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="privacy-agreement">
                        <input type="checkbox" name="privacy-agreement" id="privacy-agreement" required>
                        I agree to the <a class="link-pink" href="#">privacy policy</a> of CliniCare
                    </label>
                </div>
            </div>

            <button class="button btn-signup" type="submit" name="register-user">Register</button>
        </form>
    </div>
</main>

<?php include_once './_footer.php'; ?>