<?php
require_once "inc/database.php";

if(isset($_SESSION["loggedin"])) {
    header("location: ./index.php");
}

$view = "views/login.php";
$title = "WWI inloggen";

//Check if the method is POST to determine if you should handle the request or send it to the login page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Clear error session variables
    $_SESSION["username_err_l"] = NULL;
    $_SESSION["password_err_l"] = NULL;
    $_SESSION["username_l"] = NULL;

    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = "";

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

    // Validate credentials
    if (empty($_POST["username_err"]) && empty($_POST["password_err"])) {

        // Create database object
        $wwic = new wwic_db;

        // Get the user data from the db
        $user_data = $wwic->get_user_data($username);

        // Check if the user is known
        if (empty($user_data)) {
            $_SESSION["username_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout";
            $_SESSION["password_err_l"] = "Wachtwoord en gebruikersnaam combinatie fout";
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
}

include "template.php";
