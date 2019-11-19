<?php
//read which wishlist to display
if(isset($_GET["w"])){
    $w = $_GET["w"];
}
else {
    print("witness some errors (errorpage hasn't been made yet):<br>");
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
$products = $db_custom->wishlistProducts($wishlist);

//test if wishlist is allowed to be displayed
//owner is logged in, and wants to view his own list -> display
//user in not logged in, but list is shared          -> display
//else                                               -> dont display
if(isset($_SESSION["loggedin"]) && ($_SESSION["user_id"] == $owner_id)){
    $display = TRUE;
}
elseif($shared){
    $display = TRUE;
}
else{
    $display = FALSE;
    print("not allowed to view this list (errorpage hasn't been made yet)");
}
if($display) {
    print('
<div class="container verlanglijst" style="margin-top: 10px">

    <div class="row">
        <div class="col-4"></div>
        <div class="col-4" style="text-align: center">
            <h1>' . $name . '</h1>
        </div>
        <div class="col-4"></div>
    </div>');

    foreach($products as $num=>$record){
        print(
                '
                <div class="row verlanglijst_card" >
        <div class="col-2" >
            <img class="img-fluid productThumbnail" src = "public/images/space 2.jpg" >
        </div >
        <div class="col-5" >
            <div class="verlanglijst_text" >
                <p >
                    <b >'.$record["StockItemName"].'</b ><br >
                    '.$record["SearchDetails"].'
                </p >
                <span class="verlanglijst_prijs" ><b >'.$record["RecommendedRetailPrice"].'</b ></span >
            </div >
        </div >
        <div class="col-5 verlanglijst_buttons" >
            <form class="form-inline" style = "float: right" >
                <input class="form-control" type = "number" value = "1" name = "aantal" >
                <div class="btn btn-primary" ><i class="fa fa-cart-arrow-down" ></i ></div >
                <input type = "hidden" name = "hiddenToevoegen" value = "$product_ID" >
                <div class="btn btn-primary" style = "margin-left: 10px" ><i class="fa fa-trash-o" ></i ></div >
            </form >

        </div >
    </div >
                '
        );
    }

//    <!--<div class="row verlanglijst_card" >
//        <div class="col-2" >
//            <img class="img-fluid productThumbnail" src = "public/images/space 2.jpg" >
//        </div >
//        <div class="col-5" >
//            <div class="verlanglijst_text" >
//                <p >
//                    <b > Productnaam</b ><br >
//
//    Lorem ipsum dolor sit amet, consectetur adipiscing elit .
//    Nam imperdiet tellus ut enim venenatis, eu euismod orci dapibus . Donec tempor .
//                </p >
//                <span class="verlanglijst_prijs" ><b > Prijs</b ></span >
//            </div >
//        </div >
//        <div class="col-5 verlanglijst_buttons" >
//            <form class="form-inline" style = "float: right" >
//                <input class="form-control" type = "number" value = "1" name = "aantal" >
//                <div class="btn btn-primary" ><i class="fa fa-cart-arrow-down" ></i ></div >
//                <input type = "hidden" name = "hiddenToevoegen" value = "$product_ID" >
//                <div class="btn btn-primary" style = "margin-left: 10px" ><i class="fa fa-trash-o" ></i ></div >
//            </form >
//
//        </div >
//    </div > -->
//
//</div >
}
?>