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
                    <input type="text" name="username" class="form-control <?php echo (isset($_SESSION['username_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['username_err'])) { echo $_SESSION['username_err']; } ?></span>
                </div>
                <div class="form-group ">
                    <label class="">Wachtwoord:</label>
                    <input type="password" name="password" class="form-control <?php echo (isset($_SESSION['password_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['password_err'])) { echo $_SESSION['password_err']; } ?></span>
                </div>
                <div class="form-group center">
                    <input type="submit" class="btn custom-button-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>