<?php
require_once "inc/database.php";
require_once "inc/user.php";

$view = "views/register.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    session_start();
//
    //CLEAR ERROR SESSION VARIABLES
    $_SESSION["username_err"] = NULL;
    $_SESSION["password_err"] = NULL;
    $_SESSION["confirm_password_err"] = NULL;

    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate username
        if (empty(trim($_POST["username"]))) {

            // Store data in session variables
            $_SESSION["username_err"] = "Please enter a username.";
            header("location: ../register.php");
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM user WHERE username = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // store result
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $_SESSION["username_err"] = "This username is already taken";
                        header("location: ../register.php");
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            $stmt->close();
        }
//
//        // Validate password
//        if (empty(trim($_POST["password"]))) {
//            $_SESSION["password_err"] = "Please enter a password";
//            header("location: ../register.php");
//        } elseif (strlen(trim($_POST["password"])) < 6) {
//            $_SESSION["password_err"] = "Password must have atleast 6 characters";
//            header("location: ../register.php");
//        } else {
//            $password = trim($_POST["password"]);
//        }
//
//        // Validate confirm password
//        if (empty(trim($_POST["confirm_password"]))) {
//            $_SESSION["confirm_password_err"] = "Please confirm password";
//            header("location: ../register.php");
//        } else {
//            $confirm_password = trim($_POST["confirm_password"]);
//            if ($password != $confirm_password) {
//                $_SESSION["confirm_password_err"] = "Password did not match";
//                header("location: ../register.php");
//            }
//        }
//
//        // Check input errors before inserting in database
//        if (empty($_SESSION["username_err"]) && empty($_SESSION["password_err"]) && empty($_SESSION["confirm_password_err"])) {
//
//            // Prepare an insert statement
//            $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
//
//            if ($stmt = $mysqli->prepare($sql)) {
//                // Bind variables to the prepared statement as parameters
//                $stmt->bind_param("ss", $param_username, $param_password);
//
//                // Set parameters
//                $param_username = $username;
//                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
//
//                // Attempt to execute the prepared statement
//                if ($stmt->execute()) {
//                    // Redirect to login page
//                    header("location: ../login.php");
//                } else {
//                    echo "Something went wrong. Please try again later.";
//                }
//            }
//
//            // Close statement
//            $stmt->close();
//        }
//
//        // Close connection
//        $mysqli->close();
//    }
}

include "template.php";