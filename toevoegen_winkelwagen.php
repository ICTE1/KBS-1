<?php
session_start(); ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css"> <!-- verwijder voor rolout , net als php -->
</head>
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
<div>
<form method="post" class="form-inline">
    <input type="number" style="width: 60px;" class='form-control text-right' name="aantal"  min="1" value="<?php print($aantal);?>">
    <input type="hidden" name="hiddenToevoegen">
    <input type="submit" class="btn btn-primary" value="Update winkelwagen">
</form>
</div>
</body>
</html>


