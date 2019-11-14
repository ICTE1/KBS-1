<?php
session_start(); ?>
    <html>
    <body>
    <div align='center'> <!-- maak dit in bootstrap -->
<?php

function legeWinkelwagen(){
    print("<h1>Uw winkelwagen is leeg.</h1>");
    print("
    <form>
    <input type='submit' value='ververs'>
    <form>
    ");
}


if(!isset($_SESSION["winkelWagen"])){
    legeWinkelwagen();
}
else{ 
    if(isset($_POST["hiddenVerwijderen"])){ // verwijderdt item uit winkelwagen vanuit form hieronder
        unset($_SESSION["winkelWagen"][$_POST["hiddenVerwijderen"]]);
        }
    
        if(isset($_POST["hiddenToevoegen"])){ /* zet aantal van het product in de winkelwagen vanuit update winkelwagen form */
            $_SESSION["winkelWagen"][$_POST["hiddenToevoegen"]] = $_POST["aantal"];
        }

    if(count($_SESSION["winkelWagen"]) == 0){ // kijkt of er producten in de winkel wagen zit
        legeWinkelwagen();
    }
    else{
     

    // database conn for ophalen details producten

    if(isset($_POST["hiddenVerwijderen"])){ // verwijderdt item uit winkelwagen vanuit form hieronder
    unset($_SESSION["winkelWagen"][$_POST["hiddenVerwijderen"]]);
    }

    if(isset($_POST["hiddenToevoegen"])){ /* zet aantal van het product in de winkelwagen vanuit update winkelwagen form */
        $_SESSION["winkelWagen"][$_POST["hiddenToevoegen"]] = $_POST["aantal"];
    }

    

    // print de winkel wagen met verwijder knop per product en aanpas knoppen
    foreach($_SESSION["winkelWagen"] as $productLoop => $aantalLoop){

        print(" 
        <div>
        <form method='post' style='display: inline;'>
            $productLoop x $aantalLoop
            <input type='hidden' name='hiddenVerwijderen' value='$productLoop'>
            <input type='submit' value='Product verwijderen uit winkelwagen'> 
        </form>
        <form method='post' style='display: inline;'>
            <input type='number' name='aantal'  min='1' value='$aantalLoop'>
            <input type='hidden' name='hiddenToevoegen' value='$productLoop'>
            <input type='submit' value='Update winkelwagen'>
        </form>
        <div>
        ");

        }
    }
}
?>
    </div>
    </body>
    </html>
