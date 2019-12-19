<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
//var_dump($products);
//if allowed to display: print html
if($display) {
    //print shared alert
    if($notification == "shared"){
        print(
            '<div class="alert calert-primary" role="alert"> Verlanglijst is gedeeld!</div>'
        );
    }
    elseif($notification == "unshared"){
        print(
        '<div class="alert calert-primary" role="alert"> Verlanglijst is niet meer gedeeld!</div>'
        );
    }
    elseif($notification == "deleted"){
        print(
        '<div class="alert calert-primary" role="alert"> Product is verwijderd uit je verlanglijst!</div>'
        );
    }
    elseif($notification == "addAll"){
        print(
        '<div class="alert calert-primary" role="alert"> Verlanglijst is aan winkelwagen toegevoegd!</div>'
        );
    }
    elseif($notification == "added"){
        print(
        '<div class="alert calert-primary" role="alert"> Product is aan winkelwagen toegevoegd!</div>'
        );
    }

    //print title
    print('
        <div class="container product_card" style="margin-top: 10px">

            <div class="row">
                    <h1 style="margin: 0 auto">' . $name . '</h1>
            </div>
    ');
    //cycle through products
    foreach ($products as $num => $record) {
        print('
                <div class="row product_card_card" >
        <div class="col-sm-2" >
            <img class="img-fluid productThumbnail" src = "'); $foto_url = ("public/images/productinvulling/" . $products_db->get_product_photo($record["StockItemID"])[0]["url"]); print($foto_url .'" >
        </div >
        <div class="col-sm-5" >
            <div class="product_card_text" >
                <p >
                    <b >' . $record["StockItemName"] . '</b ><br >
                    ' . $record["SearchDetails"] . '
                </p >
                <span class="product_card_prijs" ><b >€' . number_format($record["RecommendedRetailPrice"], 2, ",", ".") . '</b ></span >
            </div >
        </div >
        <div class="col-sm-5 product_card_buttons" >
            <div style = "float: right">
                <form class="form-inline" id="form_'.$record["StockItemID"].'" method="post">
                    <input class="form-control" onfocusout="updateAmount(this);" type = "number" value = "1" name = "aantal" min="1" max="1000">
                    <button class="btn custom-button-primary" onclick="submitOnClick(\'form_'.$record["StockItemID"].'\')" name="message" value="add"><i class="fa fa-cart-arrow-down" ></i ></button >
                    <input type = "hidden" name = "Product" value = '.$record["StockItemID"].' >');
                    if($owned){
                        print('<button class="btn custom-button-primary" style = "margin-left: 10px" name="message" value="delete" onfocus="submitOnClick(\'form_'.$record["StockItemID"].'\')"><i class="fa fa-trash-o"></i ></button>');}
                print('</form>
            </div>

        </div >
    </div >
                ');
    }

    //print totale prijs en alles toevoegen aan winkelwagen
    //print share button
    print('<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="col-sm-6">
                <div style="float: left;">');
    if($owned && $shared){
        print('<div>
            Je verlanglijst is gedeeld
        <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="message" value="unshared">
                      <div class="btn custom-button-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-times"></i> Niet meer delen</div>
                 </form>
            </div>');
    }
    elseif(!$shared){
        print('
            <div>
                 Je verlanglijst staat op privé 
                 <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="message" value="shared">
                      <div class="btn custom-button-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-share-square-o"></i> delen</div>
                 </form>
            </div>');
    }
    else{
        print('Je bekijkt een gedeelde verlanglijst');
    }
    print("</div></div><div class='col-sm-2'></div><div class='col-sm-4'>
                <form method='post' id='addAll'>
                "); foreach($products as $product){print("<input type='hidden' id='".$product["StockItemID"]."' name='".$product["StockItemID"]."' value='1'>");} print("
                <h4><button type='submit' class='btn custom-button-primary' name='message' value='add all'>Alles toevoegen aan winkelwagen</h4>
                </form>
           </div>");

    print('</div>
        </div>
    </div>
    </div></div>');
}
else {
    header("Location: error.php?error=Deze lijst is niet openbaar gezet door de eigenaar");
}
?>