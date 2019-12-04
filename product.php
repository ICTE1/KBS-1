<?php
require_once "inc/database.php";
require_once "inc/package.php";

$wwi = new wwi_db();
$wwic = new wwic_db();


$id = $_GET['p'];

$product = $wwi->productInfo($id);

$content = $wwic->get_product_photo($id);

if ($product === NULL ) {
    header("location: 404.php");
}

$similar = $wwi->get_similar_products($id);

$reviews = $wwic->get_product_reviews($id);

if(isset($_POST["message"])) {
    if ($_POST["message"] == "Nu kopen") {
        addToCart($_POST["Product"], $_POST["aantal"]);
    } elseif ($_POST["message"] == "verlanglijst") {
        $user_id = $_SESSION["user_id"];
        $wishlist_id = $wwic->userWishlists($user_id);

        $wwic->wishlistAdd($wishlist_id, $_POST['Product']);
    }
}

$view = "views/product.php";


include "template.php";