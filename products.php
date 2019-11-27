<?php
include_once "inc/database.php";

if (isset($_GET['c'])) {
    // dit word alleen uitgevoerd als er een categorie parameter is meegegeven.
    $Category = $_GET['c'];
    $db = new wwi_db();

      $products_to_show = $db->get_products_by_category($Category);


    $view = 'views/products.php';


    include 'template.php';

} else
{
    // Geen parameter meegekregen, doe iets!
    print ("Geen product categories");
}


function show_products ($products){
    $number = count($products);
    for($i=0; $i< $number;$i+=3) {
        $product1=$products[$i];
        $product2=$products[$i+1];
        $product3=$products[$i+2];
        print(
            "
            <div class= 'row justify-content-around'>
                <div class='col-md-3 product'>
                    <H4>".$product1["ProductName"]."</H4>
                    <H5>€".$product1["Price"]."</H5>
                    <span>".$product1["Category"]."</span>
                    <img width='150' src='https://cdn0.iconfinder.com/data/icons/business-mix/512/cargo-512.png'/>
                </div>
                <div class='col-md-3 product'>
                    <H4>".$product2["ProductName"]."</H4>
                    <H5>€".$product2["Price"]."</H5>
                    <span>".$product1["Category"]."</span>
                    <img width='150' src='https://cdn0.iconfinder.com/data/icons/business-mix/512/cargo-512.png'/>
                </div>
                <div class='col-md-3 product'>
                    <H4>".$product3["ProductName"]."</H4>
                    <H5>€".$product3["Price"]."</H5>
                    <span>".$product1["Category"]."</span>
                    <img width='150' src='https://cdn0.iconfinder.com/data/icons/business-mix/512/cargo-512.png'/>
                </div>
            </div>
                          
            
            "
        );
    }

}
