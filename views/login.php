<?php
/*
 * TO DO:
 *
 * Create check to see if user is already logged in
 *
 */
?>
<div class="login">
    <div class="container">
        <div class="login-box">
         <h2 class="center ">Inloggen</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label class="">Naam:</label>
                    <input type="text" name="username" <?php if (isset($_SESSION["username_l"])) { echo "value=" . $_SESSION["username_l"] . ""; }?> class="form-control  <?php echo (isset($_SESSION['username_err_l'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['username_err_l'])) { echo $_SESSION['username_err_l']; } ?></span>
                </div>
                <div class="form-group ">
                    <label class="">Wachtwoord:</label>
                    <input type="password" name="password" class="form-control <?php echo (isset($_SESSION['password_err_l'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['password_err_l'])) { echo $_SESSION['password_err_l']; } ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn custom-button-primary" value="Login">
                </div>
                <p>Heb je nog geen account? <a href="register.php">Registreer hier.</a></p>
            </form>
        </div>
    </div>
</div>