<!--TODO:
-form for adding to cart functionality
-delete from wishlist
-images per product
-->
<?php
//read which wishlist to display
if(isset($_GET["w"])){
    $w = $_GET["w"];
}
else {
    print("witness some errors (errorpage hasn't been made yet):<br>");
}

//check for share command
$cmd_shared = 0;
if(isset($_POST["share"])){
    if($_POST["share"]){
        $db_custom->shareWishlist($w);
        $cmd_shared = 1;
    }
    else{
        $db_custom->unshareWishlist($w);
        $cmd_shared = 2;
    }

}

//put wishlist info into variables
$wishlist = $db_custom->wishlistInfo($w);
if ($wishlist["name"] == NULL){
    $wishlist["name"] = "Verlanglijst";
}
$name = $wishlist["name"];
$owner_id = $wishlist["customer_id"];
$shared = $wishlist["shared"];

//put wishlist products into variable
$products = $db_custom->wishlistProducts($w);

//test if wishlist is allowed to be displayed
//owner is logged in, and wants to view his own list -> display
//user in not logged in, but list is shared          -> display
//else                                               -> dont display
if(isset($_SESSION["loggedin"]) && ($_SESSION["user_id"] == $owner_id)){
    $display = TRUE;
    $owned = TRUE;
}
elseif($shared){
    $display = TRUE;
}
else{
    $display = FALSE;
    print("not allowed to view this list (errorpage hasn't been made yet)");
}


//if allowed to display: print html
if($display) {
    //print shared alert
    if($cmd_shared == 1){
        print(
            '<div class="alert alert-primary" role="alert"> Verlanglijst is gedeeld!</div>'
        );
    }
    elseif($cmd_shared == 2){
        print(
        '<div class="alert alert-primary" role="alert"> Verlanglijst is niet meer gedeeld!</div>'
        );
    }
    //print title
    print('
<div class="container verlanglijst" style="margin-top: 10px">

    <div class="row">
        <div class="col-4"></div>
        <div class="col-4" style="text-align: center">
            <h1>' . $name . '</h1>
        </div>
        <div class="col-4"></div>
    </div>');
    //print product cards
    foreach ($products as $num => $record) {
        print('
                <div class="row verlanglijst_card" >
        <div class="col-2" >
            <img class="img-fluid productThumbnail" src = "public/images/space 2.jpg" >
        </div >
        <div class="col-5" >
            <div class="verlanglijst_text" >
                <p >
                    <b >' . $record["StockItemName"] . '</b ><br >
                    ' . $record["SearchDetails"] . '
                </p >
                <span class="verlanglijst_prijs" ><b >' . $record["RecommendedRetailPrice"] . '</b ></span >
            </div >
        </div >
        <div class="col-5 verlanglijst_buttons" >
            <div style = "float: right">
                <form class="form-inline" id="form_'.$record["StockItemID"].'">
                    <input class="form-control" type = "number" value = "1" name = "aantal" >
                    <div class="btn btn-primary" ><i class="fa fa-cart-arrow-down" ></i ></div >
                    <input type = "hidden" name = "hiddenToevoegen" value = '.$record["StockItemID"].' >
                    <div class="btn btn-primary" style = "margin-left: 10px" ><i class="fa fa-trash-o"></i ></div >
                </form>
            </div>

        </div >
    </div >
                '
        );
    }

    //print share button
    print('<div class="row">
            <div class="col-12">
                <div style="float: left; margin-top: 10px">');
    if($owned && $shared){
        print('<div style="float: left; margin-bottom: 10px">
            Je verlanglijst is gedeeld
        <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="share" value=0>
                      <div class="btn btn-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-times"></i> Niet meer delen</input>
                 </form>
            </div>');
    }
    elseif(!$shared){
        print('
            <div style="float: left; margin-bottom: 10px">
                 Je verlanglijst staat op privé 
                 <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="share" value=1>
                      <div class="btn btn-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-share-square-o"></i> delen</input>
                 </form>
            </div>');
    }
    else{
        print('Je bekijkt een gedeelde verlanglijst');
    }
    print('</div>
        </div>
    </div>');
}
?>