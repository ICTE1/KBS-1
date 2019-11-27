<?php
require_once "inc/database.php";

//TODO:
//form for adding to cart functionality
//images per product

$db_custom = new wwic_db();
$db_wwi = new wwi_db();

//read which wishlist to display
if(isset($_GET["w"])){
    $w = $_GET["w"];
}
else {
    header('Location: login.php');
}

//check for action commands
$cmd_shared = 0;
if(isset($_POST["share"])){
    if($_POST["share"]){
        $db_custom->shareWishlist($w);
        $cmd_shared = 1;
    }
    else{
        $db_custom->unshareWishlist($w);
        $cmd_shared = 2;
    }

}
if(isset($_POST["Product"])){
    print($db_custom->wishlistDelete($w, $_POST["Product"]));
}

//put wishlist info into variables
$wishlist = $db_custom->wishlistInfo($w);
if ($wishlist["name"] == NULL){
    $wishlist["name"] = "Verlanglijst";
}
$name = $wishlist["name"];
$owner_id = $wishlist["customer_id"];
$shared = $wishlist["shared"];

//put wishlist products into variable
$products = $db_custom->wishlistProducts($w);

//test if wishlist is allowed to be displayed
//owner is logged in, and wants to view his own list -> display and set owner permissions to true
//user in not logged in, but list is shared          -> display
//else                                               -> dont display
$owned = FALSE;
if(isset($_SESSION["loggedin"]) && ($_SESSION["user_id"] == $owner_id)){
    $display = TRUE;
    $owned = TRUE;
}
elseif($shared){
    $display = TRUE;
}
else{
    $display = FALSE;
    print("not allowed to view this list (errorpage hasn't been made yet)");
}

$view = "views/verlanglijst.php";
include "template.php";