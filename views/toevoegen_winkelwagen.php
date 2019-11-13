<?php
session_start(); ?>
<html>
<body>
<?php
if(!isset($_SESSION["winkelWagen"])){ $_SESSION["winkelWagen"] = array(); } /* deze variabele is nodig om een winkelwagen te kunnen vullen */


/* deze variable moet in eindfase er uit zijn*/
$product = "123";   /* deze variable hoort vanuit de product pagina te worden uitgevraagd. het gaat hier om het prouductID uit de database. */

$aantal = 1; /* zet standaard aantal op 1, wordt hier na uitgevraagd wanneer er al een aantal bestaat*/



if(isset($_POST["hiddenToevoegen"])){ /* zet aantal van het product in de winkelwagen */
        $_SESSION["winkelWagen"][$product] = $_POST["aantal"];
}

if(isset($_SESSION["winkelWagen"][$product])){ /* haalt aantal uit winkelwagen voor de counter in het form */
    $aantal = $_SESSION["winkelWagen"][$product];
}
   /*hier onder een form om producten toe te voegen aan de winkelwagen */
   ?>

<form method="post">
    <input type="number" name="aantal"  min="1" value="<?php print($aantal);?>">
    <input type="hidden" name="hiddenToevoegen">
    <input type="submit" value="Update winkelwagen">
</form>
</body>
</html>


