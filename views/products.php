
<div class="">
    <div class="product-list">
    <?php 
        $number = count($products_to_show);
        print ("<span>{$number} resultaten</span>");
        if ($number  <= 0 ){
            print("<p>Geen producten</p>");
        }
    ?>

    
    <?php if (isset($_GET['c']) == false):?>

    <div class='sorting-controls '>
        <span class='product-sorting-btn'>
            <a href="<?php print  (generate_sorting_link("naam") ); ?>">
            Naam <i class='fa fa-sort'></i>
            </a>
        </span>

        <span class='product-sorting-btn'>
            <a href="<?php print (generate_sorting_link("prijs") ); ?>">
            Prijs <i class='fa fa-sort'></i>
            </a>
        </span>
        
        <span><i class="fa fa-filter"></i></span>         
    </div>
    </div>
    <?php endif;?>

  
    <?php
   show_products($products_to_show);
    ?>
</div>