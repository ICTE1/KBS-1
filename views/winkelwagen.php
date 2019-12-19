<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php
if($notification == "deleted") {
    print(
    '<div class="alert calert-primary" role="alert"> Product is verwijderd uit je winkelwagen!</div>'
    );
}
?>

<div class="container" style="margin-top: 10px; margin-bottom: 10px;">
    <h1>Winkelwagen</h1>

   <?php 
   //test if there is a shopping cart
  if( shoppingCartExists()) {
  
    printShoppingCart();

    }
    //if cart is empty:
    else{
        print("<h2>Uw winkelwagen is leeg.</h2>");
    }
   ?>
</div>