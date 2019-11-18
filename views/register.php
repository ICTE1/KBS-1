<div class="login">
    <div class="container">
        <div class="login-box">
            <h2>Registreer</h2>
            <p>Vul het formulier in om een account aan te maken</p>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label>Naam</label>
                    <input type="text" name="username" class="form-control <?php echo (isset($_SESSION['username_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['username_err'])) { echo $_SESSION['username_err']; } ?></span>
                </div>
                <div class="form-group">
                    <label>Wachtwoord</label>
                    <input type="password" name="password" class="form-control <?php echo (isset($_SESSION['password_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['password_err'])) { echo $_SESSION['password_err']; } ?></span>
                </div>
                <div class="form-group">
                    <label>Herhaal wachtwoord</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (isset($_SESSION['confirm_password_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="help-block"><?php if(isset($_SESSION['confirm_password_err'])) { echo $_SESSION['confirm_password_err']; } ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Registreren">
                </div>
                <p>Heb je al een account? <a href="login.php">Log hier in.</a></p>
            </form>
        </div>
    </div>
</div>