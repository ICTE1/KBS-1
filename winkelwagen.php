<?php
require_once "inc/database.php";
require_once "inc/package.php";

$databaseWWI = new wwi_db();
$prijsTot = 0; // zet start bedrag in voor bestelling

if(isset($_POST["hiddenVerwijderen"])){ // verwijderdt item uit winkelwagen vanuit form hieronder
    unset($_SESSION["winkelWagen"][$_POST["hiddenVerwijderen"]]);
    }

if(isset($_POST["hiddenToevoegen"])){ // voeg toe aan winkelwagen
    addToCart($_POST["hiddenToevoegen"], $_POST["aantal"]);
}

if(isset($_POST["hiddenUpdate"])){ //zet aantal in de sessie
    $_SESSION["winkelWagen"][$_POST["hiddenUpdate"]] = $_POST["aantal"];
}


$view = 'views/winkelwagen.php';
$title = 'WWI Winkelwagen';

include 'template.php';
