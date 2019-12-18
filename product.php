<?php
require_once "inc/package.php";
require_once "inc/package.php";

$products_db = new Products();
$wishlist_db = new Wishlist();
$review_db = new Review();


$id = $_GET['p'];

$product = $products_db->productInfo($id)[0];

$content = $products_db->get_product_photo($id);

if ($product === NULL ) {
  //  header("location: 404.php");
}

$similar = $products_db->get_similar_products($id);

$reviews = $products_db->get_product_reviews($id);

if(isset($_POST["message"])) {
    if ($_POST["message"] == "Nu kopen") {
        addToCart($_POST["Product"], $_POST["aantal"]);
    } elseif ($_POST["message"] == "verlanglijst") {
        $user_id = $_SESSION["user_id"];
        $wishlist_id = $wishlist_db->userWishlists($user_id);

        $wishlist_db->wishlistAdd($wishlist_id, $_POST['Product']);
    }
}


//Add review to database if method is post and type is review
if(isset($_POST['review'])) {

    $product_id = $id;
    $r_name = clean_input($_POST['name']);
    $stars = clean_input($_POST['stars']);
    $review = clean_input($_POST['reviewtext']);
    $r_email = clean_input($_POST['email']);

    $review_db->insert_review($product_id, $r_name, $stars, $review, $r_email);

    $_POST['name'] = NULL;
    $_POST['stars'] = NULL;
    $_POST['reviewtext'] = NULL;
    $_POST['email'] = NULL;

    // FIX for review not showing up
    header("Location: product.php");

}

$view = "views/product.php";


include "template.php";