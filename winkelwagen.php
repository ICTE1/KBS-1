<?php
session_start(); ?>
    <html>
    <head>
    <link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css">
    </head>
    
    <body>
    
    <div class="container">
    
    <h1>WinkelWagen</h1>
    
    <form>
    <input type='submit' class='btn btn-primary' value='ververs'>
    </form>

    
<?php
function legeWinkelwagen(){
    print("<h2>Uw winkelwagen is leeg.</h2>");
}


if(!isset($_SESSION["winkelWagen"])){ // kijkt of de winkelWagen sessie variabele bestaat en geeft hierdoor dat de winkelwagen leeg is of niet
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

    
    /* test data
    $_SESSION["winkelWagen"][1423] = 4;
    $_SESSION["winkelWagen"][54] = 18;
    $_SESSION["winkelWagen"][13] = 5;
    $_SESSION["winkelWagen"][8] = 60;
    $_SESSION["winkelWagen"][98] = 12;
    */
    $prijsTot = 0; // zet start bedrag in voor bestelling

    // V print de winkelwagen met verwijder knop per product en aanpas knoppen, totaal en betaal place holder V

    print("<div class='card-collum'  style='padding: 30px;'>"); 
    foreach($_SESSION["winkelWagen"] as $productLoop => $aantalLoop){
        $prijsLoop = $productLoop*$aantalLoop;
        $prijsTot = $prijsTot + $prijsLoop;
        print(" 
        <div style='padding: 10px;'>
        <div class='card'>
            <div class='card-header'>
                $productLoop
            </div>
            
            <div class='card-body'>
            place holder voor product informatie en foto
            
            </div>

            <div class='card-footer'>
                <div>
                    <div class='float-right'>

                    <form method='post' class='form-inline'>
                        aantal:
                        <input type='number' class='form-control m-1' name='aantal' style='width: 60px;' min='1' value='$aantalLoop'>
                        <input type='hidden' name='hiddenToevoegen' value='$productLoop'>
                        <input type='submit' class='btn btn-primary' value='Update'>
                    </form>
                        
                    <form method='post' class='text-right'>
                        <input type='hidden' name='hiddenVerwijderen' value='$productLoop'>
                        <input type='submit' class='btn btn-primary' value='Verwijderen'> 
                    </form>
                    
                    <div class='text-right'> Prijs: $prijsLoop EURO </div>
                    </div>  
                </div>   
            </div>
            </div>
        </div>
        ");

        }
         $prijsVerzend = $prijsTot + 5;
         $_SESSION["prijsBestelling"] = $prijsVerzend;
        print("
        <div class='card'>
            <div class='card-body text-right'>
            Prijs artikelen: $prijsTot EURO
            <br>
            verzendkosten: 5 EURO
            </div>
            <div class='card-footer text-right'>
            <form> 
            <h4>Totaal: $prijsVerzend EURO   <input type='submit' class='btn btn-primary' value='betalen'></h4>
            </form>
            </div>
        </div>
        ");
        

        print("</div>");
    }
}
?>
    
    
    </div>
    </body>
    </html>
