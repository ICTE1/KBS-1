<?php
require_once "inc/database.php";

$view = "views/register.php";
$title = "WWI registreren";

// Create a database object
$user = new User();

// Check if the method is POST to determine if you should handle the request or send it to the login page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Clear error session variables
    $_SESSION["username_err_r"] = NULL;
    $_SESSION["password_err_r"] = NULL;
    $_SESSION["confirm_password_err_r"] = NULL;
    $_SESSION["username_r"] = NULL;

    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate username
        if (empty(trim($_POST["username"]))) {

            // Store data in session variables
            $_SESSION["username_err_r"] = "Vul een gebruikersnaam in.";
        } else {
         

            if($user->check_if_user_exists($_POST["username"])) {
                $_SESSION["username_err_r"] = "Gebruikersnaam al in gebruik";
            } else {
                $username = trim($_POST["username"]);
                $_SESSION["username_r"] = trim($_POST["username"]);
            }

        }
    }
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $_SESSION["password_err_r"] = "Vul een wachtwoord in";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $_SESSION["password_err_r"] = "Wachtwoord moet minimaal 6 karakters";
        $password = trim($_POST["password"]);
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $_SESSION["confirm_password_err_r"] = "Graag het wachtwoord bevestigen";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $_SESSION["confirm_password_err_r"] = "Wachtwoord is niet gelijk";
        }
    }

    // Check input errors before inserting in database
    if (empty($_SESSION["username_err_r"]) && empty($_SESSION["password_err_r"]) && empty($_SESSION["confirm_password_err_r"])) {
        $password = clean_input($password);
        $param_username = clean_input($username);
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Create the user using the db object
        $user->create_user($param_username, $param_password);

        header("location: ./login.php");
    }
}

include "template.php";
