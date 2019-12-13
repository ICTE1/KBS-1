
<div class="product-list">
    <?php 
        $number = count($products_to_show);
        print ("<span>{$number} resultaten</span>");
    ?>
    
    <?php if (isset($_GET['c']) == false && count ($products_to_show) > 0 ):?>
    
    <div class='sorting-controls'>
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
    <?php else : ?>
    <img class="img-fluid" style=" max-width: 35%; display: block; margin-left: auto; margin-right: auto;" src="public/images/John.gif">

    <?php endif;?>

  
    <?php
   show_products($products_to_show);
    ?>
</div>