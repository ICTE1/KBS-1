<?php
require_once "inc/database.php";
require_once "inc/package.php";

$wwic_db = new wwic_db2();
$view = "views/selecteer_lijst.php";
$title = "WWI Verlanglijsten";

if($_SESSION["loggedin"] == false){
    header("Location: login.php");
}
else{
    $userid = $_SESSION["user_id"];
    $username = $_SESSION["username"];
}

$notification = "";
if(isset($_POST["action"])){
    if($_POST["action"] == "ProductPage"){
        $view = "views/toevoegen_lijst.php";
    }
    elseif($_POST["action"] == "addList"){
        $wwic_db->add_wishlist($userid, clean_input($_POST["name"]));
        $notification = "add";
    }
    elseif($_POST["action"] == "deleteList"){
        $wwic_db->delete_wishlist($_POST["wishlist"]);
        $notification = "delete";
    }
    elseif($_POST["action"] == "editDone"){
        header("Location: product.php?p=".$_POST["product"]);
    }
    elseif($_POST["action"] == "addProduct"){
        $wwic_db->wishlistAdd($_POST["wishlist"], $_POST["product"]);
        $view = "views/toevoegen_lijst.php";
    }
}



$wishlists = $wwic_db->userWishlists($userid);
if ( $wishlists == null)
    $wishlists =  array();

include 'template.php';
