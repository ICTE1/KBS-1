<?php
require_once "inc/database.php";
require_once "inc/user.php";

$view = "views/login.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "joe is request";
    die();
// Include config file
//require_once "config.php";
//
//session_start();
//
//// Define variables and initialize with empty values
//$username = $password = "";
//$username_err = $password_err = "";
//
//// Check if username is empty
//if (empty(trim($_POST["username"]))) {
//    $_SESSION["username_err"] = "Please enter username";
//    header("location: ../login.php");
//} else {
//    $username = trim($_POST["username"]);
//}
//
//// Check if password is empty
//if (empty(trim($_POST["password"]))) {
//    $_SESSION["password_err"] = "Please enter your password";
//    header("location: ../login.php");
//} else {
//    $password = trim($_POST["password"]);
//}
//
//// Validate credentials
//if (empty($_POST["username_err"]) && empty($_POST["password_err"])) {
//    // Prepare a select statement
//    $sql = "SELECT id, username, password FROM users WHERE username = ?";
//    echo "voor";
//    if ($stmt = $mysqli->prepare($sql)) {
//        echo "na";
//        // Bind variables to the prepared statement as parameters
//        $stmt->bind_param("s", $param_username);
//
//        // Set parameters
//        $param_username = $username;
//
//        // Attempt to execute the prepared statement
//        if ($stmt->execute()) {
//            // Store result
//            $stmt->store_result();
//
//            // Check if username exists, if yes then verify password
//            if ($stmt->num_rows == 1) {
//                // Bind result variables
//                $stmt->bind_result($id, $username, $hashed_password);
//                if ($stmt->fetch()) {
//                    if (password_verify($password, $hashed_password)) {
//                        // Password is correct, so start a new session
//                        session_start();
//
//                        // Store data in session variables
//                        $_SESSION["loggedin"] = true;
//                        $_SESSION["id"] = $id;
//                        $_SESSION["username"] = $username;
//
//                        // Redirect user to welcome page
//                        header("location: ./welcome.php");
//                    } else {
//                        // Display an error message if password is not valid
//                        $_SESSION["password_err"] = "The password you entered was not correct";
//                        header("location: ../login.php");
//                    }
//                }
//            } else {
//                // Display an error message if username doesn't exist
//                $_SESSION["username_err"] = "No account found with that username";
//                header("location: ../login.php");
//            }
//        } else {
//            echo "Oops! Something went wrong. Please try again later.";
//        }
//    }
//
//    // Close statement
//    $stmt->close();
//}
//
//// Close connection
//$mysqli->close();
}

include "template.php";