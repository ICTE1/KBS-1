<?php
session_start(); ?>
    <html>
    <body>
<?php

if(isset($_POST["hiddenVerwijderen"])){ // verwijderdt item uit winkelwagen vanuit form hieronder
unset($_SESSION["winkelWagen"][$_POST["hiddenVerwijderen"]]);
}

// print de winkel wagen met verwijder knop per product
foreach($_SESSION["winkelWagen"] as $productLoop => $aantalLoop){
print(" 
<form method='post'>
    $productLoop x $aantalLoop
    <input type='hidden' name='hiddenVerwijderen' value='$productLoop'>
    <input type='submit' value='Product verwijderen uit winkelwagen'>
    <input 
</form>
<br>
");

}
?>
    </body>
    </html>
