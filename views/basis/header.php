<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="./index.php"><img class="WorldWideImporters navbar-brand" alt="logo" src="./public/images/wide-world-importers-logo-small.png" height="70" width="170"></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <div class="dropdown">
                    <button class="dropbtn">Categorieën
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="products.php?c=Novelty Items">Novelty Items</a>
                        <a href='products.php?c=Clothing'>Clothing</a>
                        <a href="products.php?c=Mugs">Mugs</a>
                        <a href="products.php?c=T-Shirts">T-Shirts</a>
                        <a href="products.php?c=Airline Novelties">Airline Novelties</a>
                        <a href="products.php?c=Computing Novelties">Computing Novelties</a>
                        <a href="products.php?c=USB Novelties">USB Novelties</a>
                        <a href="products.php?c=Furry Footwear">Furry Footwear</a>
                        <a href="products.php?c=Toys">Toys</a>
                        <a href="products.php?c=Packaging Materials">Packaging Materials</a>
                    </div>
                </div>

            </li>
        </ul>
        <form class="form-inline my-2 search-area" method="GET" action='products.php' >
            <input class="form-control" type="search"  <?php print isset ($_GET['s'])? "value=".$_GET['s']:""; ?> name='s' placeholder="Zoeken...." aria-label="Search">
            <input class="btn" type="submit" value='Zoeken'>
        </form>
        <div class="navbar-nav" style="margin-left: auto">
            <div class="loginbutton">
                <button type="button" class="btn btn-default">
                    <a class="btn btn-outline-success my-2 my-sm-0" style="border-width: 3px" href="<?php if(isset($_SESSION["loggedin"])) { if($_SESSION["loggedin"]) { echo "logout.php"; } else { echo "logout.php"; } } else { echo "login.php"; }?>"><b><?php if(isset($_SESSION["loggedin"])) { if($_SESSION["loggedin"]) { echo "logout"; } else { echo "logout"; } } else { echo "login"; }?></b></a>
                </button>
            </div>
            <a class="nav-link text-center" href="selecteer_lijst.php"><i class="fa fa-heart navbarIcon fa-2x"></i></a>
            <a id="cart-button" class="nav-link" href="winkelwagen.php">
                <i class="fa fa-shopping-cart navbarIcon fa-2x"></i>
                <?php if(isset($_SESSION["winkelWagen"]) && !$_SESSION["winkelWagen"] == 0){print("<div class='badge rounded-circle shopping-badge'>".array_sum($_SESSION['winkelWagen'])."</div>");}?>
            </a>
        </div>
    </div>
</nav>
<?php
/**
 * Print wishlist link
 */
function generate_wishlistLink(){
    if(isset($_SESSION["user_id"])){
        $db = new Wishlist();
        $wishlist = $db->userWishlists($_SESSION["user_id"]);
        if ( $wishlist == NULL){
            print ("?w=0");
            return;
        }
        print("?w=".$wishlist["wishlist_id"]);
    }
}
?>
