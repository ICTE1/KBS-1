<?php
require_once "inc/package.php";

$products = new Products();

if (isset($_GET['c'])) {
    // dit word alleen uitgevoerd als er een categorie parameter is meegegeven.
    $Category = urldecode($_GET['c']);
  
    $products_to_show = $products->get_products_by_category($Category);


    $view = 'views/products.php';
    $title = ("WWI " . $Category);

    include 'template.php';

} else if (isset($_GET['s'])){
    
    $search_term = trim(urldecode($_GET['s']));

    
    if (isset($_GET['o'])){
      
        $products_to_show = $products->search_products($search_term, $_GET['o']);

    } else{
        $products_to_show = $products->search_products($search_term);
    }
   
    
    $view = 'views/products.php';

    include 'template.php';

} else
{
    // Geen parameter meegekregen, doe iets!
    print ("Geen product");
}


function generate_sorting_link ($type) {
    $uri = 'products.php?';

    if (isset($_GET['c'])){
        $uri .= 'c='.$_GET['c'];

    }
    if (isset($_GET['s'])){
        $uri .= 's='.$_GET['s'];

    }

    switch  ($type){
        case "naam": 
            $uri .= '&o=naam'; 
            return $uri;
      
        case "prijs":
            $uri .= '&o=prijs';
            return $uri;
        default:
        return 'error.php';
    }

}


function show_products ($products){

    $number = count($products);
    
   
    if ($number <= 0 ){
        return;
    }
print(" <div class= 'container'>" );
    for($i=0; $i< $number;$i+=3) {
        print(" <div class= 'row'>" );
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
    print("</div>");

}


function print_product  ($product ) {
   
    $Products = new Products();
    $content = $Products->get_product_photo($product['identifier']);
    
    if ( $content == null ){
        $content = [['url'=>'space.jpg']] ;
    }

    print("
    <div class='col-sm-4'>
        <div class=' center card ccart product'>
            <img src='".image_url . $content[0]['url']."' class='card-img-top' alt='product-image'>
            <div class='card-body'>
                <h5 class='card-title'>".$product['ProductName']."</h5>
                <p class='card-text'>
                €".$product['Price']."
                </p>
                <a href='product.php?p=".$product['identifier']."' class='btn btn-primary custom-button-primary'>Bekijken</a>
            </div>
        </div>
    </div>
   
    ");
} 