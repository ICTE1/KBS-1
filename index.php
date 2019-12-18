<?php
require_once "inc/package.php";


$view = "views/home.php";
include "template.php";


/*
*   The function below generates the html structures for all available categories
*
*   <div class="col-md-4">
*       <ul class="list-group list-group-flush">
*           <li class="list-group-item custom-list-group-item">Limited Stock</li>
*           <li class="list-group-item custom-list-group-item">Halloween Fun</li>
*           <li class="list-group-item custom-list-group-item">Comfortable</li>
*           <li class="list-group-item custom-list-group-item">Long Battery Life</li>
*       </ul>
*   </div>
*/

function print_categories (){
    $products = new Products ();
    
    $categorie_list = $products->get_categories();

    if ( $categorie_list == false) {
        throw new Exception ("No categories") ;
    }


    foreach ( $categorie_list as $index => $category ){

        $product = urlencode($category['category_name']);

        if ( $index == 0 ) {
            // If we are the first element, start the first column
            print ('
            <div class="col-md-4">
            <ul class="list-group list-group-flush">');
        }
        if ( $index == (count ($categorie_list))){
            // If we are the last element, end the column but don't start a new one
            print ('
            </ul></div>
            ');

        }        
        if ( $index % 4 == 0 && ! $index == 0   || $index == count ($categorie_list) ){
            // if we are divisible by 4 , end the column and start a new colmn
            print ('
            </ul>
            </div>
            <div class="col-md-4">
            <ul class="list-group list-group-flush">');
        }

      
        print ("
                <li class='list-group-item custom-list-group-item'>
                    <a href='products.php?c={$product}'>
                        {$category['category_name']}
                    </a>
                </li>") ;

    }
    print ("</ul>");
}

function print_sales(){

    $products = new Products();
    $sales = $products->get_sales();
  
    for($i =0; $i < 4; $i++){ 
        $discount =  ($sales[$i]["UnitPrice"] - $sales[$i]["RecommendedRetailPrice"]) / $sales[$i]["RecommendedRetailPrice"] * 100;
      
        $image_uri = $products->get_product_photo($sales[$i]['StockItemID']);
        if ( count($image_uri) == 0 ){
            $image_uri = [ [ "url" => '' ]];
        }

        $name = "";        
         if (strlen($sales[$i]["StockItemName"]) >= 23) {
            $name = substr($sales[$i]["StockItemName"], 0, 28) . "..." ;
        } 
        elseif (strlen($sales[$i]["StockItemName"]) <= 23) {
            $name =  $sales[$i]["StockItemName"] . "<br>";
        }
        else {
            $name =  $sales[$i]["StockItemName"];
        }



        $discount_string =  "<br><b><span class='text-attention'>" . substr($discount, 1, -13) . "% korting</span></b>"; 

       

        $unitPrice =  "€" . $sales[$i]["UnitPrice"] ;

        $image = image_url . $image_uri[0]['url'];

    

        $itemID = $sales[$i]['StockItemID'];
        print(" 
        <div class='col-md-3'>
                <div class='card ccart'>
                    <img src='".$image."' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>
                            ".$name. $discount_string."                
                        </h5>
                        <h5 class='card-title'> ".$unitPrice."</h5>
                        <a href='product.php?p=".$itemID."' class='btn custom-button-primary'>Bekijk product</a>
                    </div>
                </div>
            </div>"
            );
    
    }
}
