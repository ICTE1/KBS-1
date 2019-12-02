<?php
require_once "inc/database.php";
//require_once "inc/package.php";

$wwi = new wwi_db();
$wwic = new wwic_db();


$id = $_GET['p'];

$product = $wwi->productInfo($id);

$similar = $wwi->get_similar_products($id);

$reviews = $wwic->get_product_reviews($id);

//if(isset($_POST["message"])) {
//    if ($_POST["message"] == "add") { //mag hernoemd worden of weggehaald worden
//        addToCart($_POST["Product"], $_POST["aantal"]);
//    }
//}
$view = "views/product.php";


include "template.php";