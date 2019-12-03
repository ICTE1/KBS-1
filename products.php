<?php
include_once "inc/database.php";

$db = new wwi_db();

if (isset($_GET['c'])) {
    // dit word alleen uitgevoerd als er een categorie parameter is meegegeven.
    $Category = urldecode($_GET['c']);
  
    $products_to_show = $db->get_products_by_category($Category);


    $view = 'views/products.php';

    include 'template.php';

} else if (isset($_GET['s'])){
    
    $search_term = trim(urldecode($_GET['s']));

    if (isset($_GET['o'])){
      
        $products_to_show = $db->search_products($search_term, $_GET['o']);

    } else{
        $products_to_show = $db->search_products($search_term);
    }
   
    
    $view = 'views/products.php';

    include 'template.php';

} else
{
    // Geen parameter meegekregen, doe iets!
    print ("Geen product");
}


function show_products ($products){

    $number = count($products);
    
   
    if ($number <= 0 ){
        return;
    }
    
    for($i=0; $i< $number;$i+=3) {


        print(" <div class= 'row  align-content-around'>" );
        

        $product1_index = $i ;
        $product2_index = $i + 1;
        $product3_index = $i + 2;

        print_product($products[$product1_index]);
     

        if ( ( $product2_index >= $number ) === false ){
          print_product($products[$product2_index]);
        }

        if( ($product3_index >= $number) === false ){
         print_product($products[$product3_index]);
        }

        print("</div>");
    }

}


function print_product  ($product ){
    print("
    <div class='col-md-3 product' title='".$product['ProductName']."'>
        <H4>".$product["ProductName"]."</H4>
        <H5>€".$product["Price"]."</H5>
        <img width='150' src='https://cdn0.iconfinder.com/data/icons/business-mix/512/cargo-512.png'/>

        <span>".$product["Category"]."</span>
      
    </div>
    ");
} 