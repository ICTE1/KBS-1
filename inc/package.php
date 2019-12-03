<?php
function addToCart($item, $aantal){
    if(isset($_SESSION["winkelWagen"][$item])){
        $_SESSION["winkelWagen"][$item] += $aantal;
    }
    else {
        $_SESSION["winkelWagen"][$item] = $aantal;
    }
}