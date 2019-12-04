<?php
require_once "inc/database.php";
require_once "inc/package.php";

//TODO:
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

//put wishlist info into variables
$wishlist = $db_custom->wishlistInfo($w);
if ($wishlist["name"] == NULL){
    $wishlist["name"] = "Verlanglijst";
}
$name = $wishlist["name"];
$owner_id = $wishlist["customer_id"];
$shared = $wishlist["shared"];

//put wishlist products into variables
$products = $db_custom->wishlistProducts($w);

//check for commands
if(isset($_POST["message"])){
    //add product to shoppingcart
    if($_POST["message"] == "add"){
        addToCart($_POST["Product"], $_POST["aantal"]);
    }
    //delete product from wishlist
    elseif($_POST["message"] == "delete"){
        $db_custom->wishlistDelete($w, $_POST["Product"]);
    }
    elseif($_POST["message"] == "add all"){
        foreach($products as $product){
            $aantal = $_POST[$product["StockItemID"]];
            addToCart($product["StockItemID"], $aantal);
        }
    }
}

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
$title = 'WWI Verlanglijst';
include "template.php";
