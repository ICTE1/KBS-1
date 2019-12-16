<?php
require_once 'database/database.php';

define('image_url' ,'public/images/productinvulling/') ;


function addToCart($item, $aantal){
    if(isset($_SESSION["winkelWagen"][$item])){
        $_SESSION["winkelWagen"][$item] += $aantal;
        if($_SESSION["winkelWagen"][$item] > 1000){
            $_SESSION["winkelWagen"][$item] = 1000;
        }
    }
    else {
        $_SESSION["winkelWagen"][$item] = $aantal;
    }
}