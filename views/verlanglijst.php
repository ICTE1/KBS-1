<?php
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
        <div class="container product_card" style="margin-top: 10px">

            <div class="row">
                    <h1 style="margin: 0 auto">' . $name . '</h1>
            </div>
    ');
    //print product cards
    foreach ($products as $num => $record) {
        print('
                <div class="row product_card_card" >
        <div class="col-2" >
            <img class="img-fluid productThumbnail" src = "public/images/space 2.jpg" >
        </div >
        <div class="col-5" >
            <div class="product_card_text" >
                <p >
                    <b >' . $record["StockItemName"] . '</b ><br >
                    ' . $record["SearchDetails"] . '
                </p >
                <span class="product_card_prijs" ><b >' . $record["RecommendedRetailPrice"] . '</b ></span >
            </div >
        </div >
        <div class="col-5 product_card_buttons" >
            <div style = "float: right">
                <form class="form-inline" id="form_'.$record["StockItemID"].'" method="post">
                    <input class="form-control" type = "number" value = "1" name = "aantal" min="1">
                    <button class="btn custom-button-primary" onclick="submitOnClick(\'form_'.$record["StockItemID"].'\')" name="message" value="add"><i class="fa fa-cart-arrow-down" ></i ></button >
                    <input type = "hidden" name = "Product" value = '.$record["StockItemID"].' >');
                    if($owned){
                        print('<button class="btn custom-button-primary" style = "margin-left: 10px" name="message" value="delete" onclick="submitOnClick(\'form_'.$record["StockItemID"].'\')"><i class="fa fa-trash-o"></i ></button>');}
                print('</form>
            </div>

        </div >
    </div >
                ');
    }

    //print share button
    print('<div class="row">
            <div class="col-12">
                <div style="float: left; margin-top: 10px; margin-bottom: 10px;">');
    if($owned && $shared){
        print('<div>
            Je verlanglijst is gedeeld
        <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="share" value=0>
                      <div class="btn custom-button-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-times"></i> Niet meer delen</input>
                 </form>
            </div>');
    }
    elseif(!$shared){
        print('
            <div>
                 Je verlanglijst staat op privé 
                 <form action="verlanglijst.php?w='.$w.'" method="post" style="display: inline;" id="share">
                      <input type="hidden" name="share" value=1>
                      <div class="btn custom-button-primary" onclick="submitOnClick(\'share\')"><i class="fa fa-share-square-o"></i> delen</input>
                 </form>
            </div>');
    }
    else{
        print('Je bekijkt een gedeelde verlanglijst');
    }
    print('</div>
        </div>
    </div>
    </div></div>');
}
?>