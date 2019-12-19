<?php
require_once "inc/package.php";

//TODO:
//images per product

$products_db = new Products();
$wishlist_db = new Wishlist();

//read which wishlist to display
if(isset($_GET["w"])){
    $w = $_GET["w"];
}
else {
    header('Location: login.php');
}



//put wishlist info into variables
$wishlist = $wishlist_db->wishlistInfo($w)[0];
if ($wishlist["name"] == NULL){
    $wishlist["name"] = "Verlanglijst";
}
$name = $wishlist["name"];
$owner_id = $wishlist["customer_id"];
$shared = $wishlist["shared"];

//put wishlist products into variables
$products = $wishlist_db->wishlistProducts($w);

//check for actions and set wich notification to display
$notification = "";
if(isset($_POST["message"])){
    //add product to shoppingcart
    if($_POST["message"] == "add"){
        addToCart($_POST["Product"], $_POST["aantal"]);
        $notification = "added";
    }
    //delete product from wishlist
    elseif($_POST["message"] == "delete"){
        $wishlist_db->wishlistDelete($w, $_POST["Product"]);
        $notification = "deleted";
        //update wishlist
        $products = $wishlist_db->wishlistProducts($w);
    }
    //add all products in wishlist to shoppingcart with amounts
    elseif($_POST["message"] == "add all"){
        foreach($products as $product){
            $aantal = $_POST[$product["StockItemID"]];
            addToCart($product["StockItemID"], $aantal);
        }
        $notification = "addAll";
    }
    //set wishlist to public
    elseif($_POST["message"] == "shared"){
        $wishlist_db->shareWishlist($w);
        $notification = "shared";
    }
    //set wishlist to private
    elseif($_POST["message"] == "unshared"){
        $wishlist_db->unshareWishlist($w);
        $notification = "unshared";
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
}
$view = "views/verlanglijst.php";
$title = ('WWI '.$name);
include "template.php";
