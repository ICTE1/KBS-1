<?php
/*
 * TO DO:
 *
 * Create check to see if user is already logged in
 *
 */
?>
<div class="container">
    <div class="login-box">
     <h2 class="center custom-white">Inloggen</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label class="custom-white">Naam:</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($_SESSION['username_err'])) ? 'is-invalid' : ''; ?>">
                <span class="help-block"><?php if($_SESSION['username_err']) { echo $_SESSION['username_err']; } ?></span>
            </div>
            <div class="form-group ">
                <label class="custom-white">Wachtwoord:</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($_SESSION['password_err'])) ? 'is-invalid' : ''; ?>">
                <span class="help-block"><?php if($_SESSION['password_err']) { echo $_SESSION['password_err']; } ?></span>
            </div>
            <div class="form-group center">
                <input type="submit" class="btn custom-white cbtn-secundary" value="Login">
            </div>
        </form>
    </div>
</div>