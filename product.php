<?php
require_once "inc/database.php";

$wwi = new wwi_db();

$view = "views/product.php";

$product = $wwi->productInfo('70');

include "template.php";