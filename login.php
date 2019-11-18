<?php
require_once "inc/database.php";
require_once "inc/user.php";

session_start();

$view = "views/login.php";

//Check if the method is POST to determine if you should handle the request or send it to the login page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_SESSION["loggedin"] === true) {
        header("location: ./index.php");
    }

    //Clear error session variables
    $_SESSION["username_err"] = NULL;
    $_SESSION["password_err"] = NULL;

    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = "";

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $_SESSION["username_err"] = "Vul een gebruikersnaam in";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $_SESSION["password_err"] = "Vul je wachtwoord in";
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
            $_SESSION["username_err"] = "Gebruiker niet bekend in het systeem";
        } else {
            // Check if the filed password matches the password in the db
            if (password_verify($password, $user_data["password"])) {

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;

                // Redirect to starting page -- login succesfull!
                header("location: ./index.php");

            } else {
                $_SESSION["password_err"] = "Wachtwoord en gebruikersnaam combinatie fout";
            }
        }
    }
}

include "template.php";