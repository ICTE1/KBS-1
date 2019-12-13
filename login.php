<?php
require_once "inc/package.php";

if(isset($_SESSION["loggedin"])) {
    header("location: ./index.php");
}

$view = "views/login.php";
$title = "WWI inloggen";

//Check if the method is POST to determine if you should handle the request or send it to the login page.
if (isLoginRequest()) {
    
    //Clear error session variables
    $_SESSION["username_err_l"] = NULL;
    $_SESSION["password_err_l"] = NULL;
    $_SESSION["username_l"] = NULL;

    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = "";


    isUsernameOrPasswordEmpty($username, $password);
   
    // Validate credentials
    if (empty($_POST["username_err"]) && empty($_POST["password_err"])) {
        login($username , $password);
    }
}

include "template.php";

/**
 * Checks if the username or password is empty 
 * 
 * @side-effect  - modifies  session variables
 */
function isUsernameOrPasswordEmpty(&$username, &$password){
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $_SESSION["username_err"] = "Vul een gebruikersnaam in";
    } else {
        $username = trim($_POST["username"]);
        $_SESSION["username_l"] = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $_SESSION["password_err_l"] = "Vul je wachtwoord in";
    } else {
        $password = trim($_POST["password"]);
    }
}


/**
 *  Log a user in if his credentials match with known credentials
 * 
 *  @side-effect  - modifies session variables
 */
function login($username, $password) {
    // Create database object
    $user_db = new User();

    // Get the user data from the db
    $user_data = $user_db->get_user_data($username)[0];


    // Check if the user is known
    if (empty($user_data)) {
        $_SESSION["username_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout 1";
        $_SESSION["password_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout 1";
    }else {
        if($user_data["activated"] === 0) {
            $_SESSION["username_err_l"] = "Account niet geactiveerd";
        }
        // Check if the filed password matches the password in the db
        elseif (password_verify($password, $user_data["password"])) {
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $user_data["id"];

            // Redirect to starting page -- login succesfull!
            header("location: ./index.php");

        } else {
            $_SESSION["username_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout";
            $_SESSION["password_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout";
        }
    }
}

/**
 * Checks if the user is sending his credentials
 * 
 */
function isLoginRequest () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset ($_POST['username'])  && isset($_POST['password']) ) {
            return true;
        }

        return false;
    }  
    return false ;
}