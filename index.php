<?php
require_once "inc/package.php";
require_once "inc/database.php";

$wwi = new wwi_db();
$wwic = new wwic_db();


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
    global $wwi;
    
    $categorie_list = $wwi->get_categories();

    if ( $categorie_list == false) {
        throw new Exception ("NO categories") ;
    }


    foreach ( $categorie_list as $index => $category ){
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
                    <a href='products.php?c={$category['category_name']}'>
                        {$category['category_name']}
                    </a>
                </li>") ;

    }
}


$view = "views/home.php";
include "template.php";