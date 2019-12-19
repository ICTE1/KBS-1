<?php
require_once "inc/package.php";

// Create a database object
$user = new User();

$products_db = new Products();
$notification = "";
if(isset($_POST["hiddenVerwijderen"])){ // verwijderdt item uit winkelwagen vanuit form hieronder
    unset($_SESSION["winkelWagen"][$_POST["hiddenVerwijderen"]]);
    $notification = "deleted";
    }

if(isset($_POST["hiddenToevoegen"])){ // voeg toe aan winkelwagen
    addToCart($_POST["hiddenToevoegen"], $_POST["aantal"]);
}

if(isset($_POST["hiddenUpdate"])){ //zet aantal in de sessie
    $_SESSION["winkelWagen"][$_POST["hiddenUpdate"]] = $_POST["aantal"];
}
if(isset($_POST["hiddenKorting"])){
    $_SESSION["discount"] = $user->apply_discount($_POST["kortingsCode"]);

//    var_dump($discount);
//    die();
}


$view = 'views/winkelwagen.php';
$title = 'WWI Winkelwagen';

include 'template.php';


function shoppingCartExists(){
    return isset($_SESSION["winkelWagen"]) && count($_SESSION["winkelWagen"]) != 0;
}

function printShoppingCart(){

    global $products_db;

    $prijsTot = 0; // zet start bedrag in voor bestelling
    //calculate and format prices
    $prijsVerzend = $prijsTot + 5;
    $prijsTot = number_format($prijsTot, 2, ",", ".");
    $prijsVerzend = number_format($prijsVerzend, 2, ",", ".");

     //print products from session
   foreach ($_SESSION["winkelWagen"] as $product => $aantal) {
    //get product info
    $data = $products_db->productInfo($product)[0];


    $prijs = $aantal * $data['RecommendedRetailPrice'];
    $prijsTot = floatval($prijsTot) + $prijs;
    //format numbers to amount of money
    $data["RecommendedRetailPrice"] = number_format($data["RecommendedRetailPrice"], 2, ",", ".");
    $prijs = number_format($prijs, 2, ",", ".");
    $foto_url = ("public/images/productinvulling/" . $products_db->get_product_photo($product)[0]["url"]); 
    print (startRow($product));
  
    showProduct($data, $product, $foto_url, $prijs, $aantal );
    // end row started at line :53
    print ( '</div>');
   
    }



    showPricesAndPayButton($prijsTot, $prijsVerzend);
}

function showPricesAndPayButton ($prijsTot, $prijsVerzend)
{
    $prijs_inclusief_verzendkosten = floatval($prijsTot) + floatval($prijsVerzend);
    $prijs_inclusief_verzendkosten_korting = round($prijs_inclusief_verzendkosten / 100 * (100 - $_SESSION["discount"]), 2);

    if ($_SESSION["discount"] != NULL) {
        print("
    <div class='card' style='background-color: #353535'>
        <div class='card-body text-right'>
            Prijs artikelen: €" . $prijsTot . "
            <br>
            verzendkosten: €5,-
        </div>
        <div class='card-footer text-right'>
            <form> 
            <h4>Totaal: €" . $prijs_inclusief_verzendkosten . " <br> Met korting: €" . $prijs_inclusief_verzendkosten_korting . "<br>  <a  class='btn custom-button-primary'  href='betaalpagina.php'>Betalen</a></h4>
            </form>
            <form method=\"post\" class=\"form-inline\" style=\"display: inline-block\">
                    <input type=\"hidden\" name=\"hiddenKorting\">
                    <input type=\"text\" class=\"form-control\" name=\"kortingsCode\" id=\"kortingsCode\" aria-describedby=\"kortingsCode\" placeholder=\"Kortings code\" required>
                    <button type=\"submit\" class=\"btn custom-button-primary\">Toevoegen</button>
            </form>
        </div>
    </div>
    ");
    $_SESSION["discount"] = NULL;
    $_SESSION["discounted_price"] = $prijs_inclusief_verzendkosten_korting;
    } else {
        print("
        <div class='card' style='background-color: #353535'>
            <div class='card-body text-right'>
                Prijs artikelen: €" . $prijsTot . "
                <br>
                verzendkosten: €5,-
            </div>
            <div class='card-footer text-right'>
                <form> 
                <h4>Totaal: €" . $prijs_inclusief_verzendkosten . " <a  class='btn custom-button-primary'  href='betaalpagina.php'>Betalen</a></h4>
                </form>
                <form method=\"post\" class=\"form-inline\" style=\"display: inline-block\">
                        <input type=\"hidden\" name=\"hiddenKorting\">
                        <input type=\"text\" class=\"form-control\" name=\"kortingsCode\" id=\"kortingsCode\" aria-describedby=\"kortingsCode\" placeholder=\"Kortings code\" required>
                        <button type=\"submit\" class=\"btn custom-button-primary\">Toevoegen</button>
                </form>
            </div>
        </div>
    ");
    }
    $_SESSION["discount"] = NULL;
}

function showProduct ($data, $product, $foto_url, $prijs, $aantal){
    global $products_db ;
    print('
    <div class="col-2" >
        <img class="img-fluid productThumbnail" alt="thumbnail product" src = "'); print($foto_url .'" >
    </div >
        <div class="col-5" >
            <div class="product_card_text" >
                <p >
                    <b >' . $data["StockItemName"] . '</b ><br >
            ' . $data["SearchDetails"] . '
                </p >
            </div >
        </div >
        <div class="col-5">
            <div style="position: absolute; bottom: 10px; right: 10px">
                <form method="post" class="form-inline" style="display: inline-block">
                    aantal:
                    <input type="number" onfocusout="submit()" class="form-control m-1" name="aantal" style="width: 60px;" min="1" max="1000" value="' . $aantal . '">
                    <input type="hidden" name="hiddenUpdate" value="' . $product . '">
                </form>
                <form method="post" class="form-inline" style="display: inline-block">
                    <input type="hidden" name="hiddenVerwijderen" value="' . $product . '">
                    <button type="submit" class="btn custom-button-primary"><i class="fa fa-trash-o"></i></button>
                </form>
                <div class="text-right">
                    Prijs per product: €' . $data["RecommendedRetailPrice"] . '
                    <br>
                    Prijs totaal: €' . $prijs . '
                </div>
            </div>
        </div>
    ');
}

function startRow ($product){
    $rowHTML = '
    <div class="row product_card_card" ';
    
    //see if this is the last item, so it doesn't need a border
    $b = array_keys($_SESSION["winkelWagen"]);
    if ($product == end($b)) {
        $rowHTML .= 'style="border-bottom: 0px"';
    }
    
    $rowHTML .= '>';
    return $rowHTML;
}
