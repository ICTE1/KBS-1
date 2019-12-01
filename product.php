<?php
require_once "inc/database.php";

$wwi = new wwi_db();
$wwic = new wwic_db();



$id = $_GET['p'];

$product = $wwi->productInfo($id);

$similar = $wwi->get_similar_products($id);

$reviews = $wwic->get_product_reviews($id);

$view = "views/product.php";


include "template.php";