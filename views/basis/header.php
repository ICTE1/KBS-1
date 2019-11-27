<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="./index.php"><img class="WorldWideImporters navbar-brand" alt="logo" src="./public/images/wide-world-importers-logo-small.png" height="70" width="170"></a>

    <div class="navbar-nav">
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
    </div>

        <form class="form-inline my-2 search-area">
            <input class="form-control" type="search" placeholder="Zoeken...." aria-label="Search">
            <button class="btn" type="submit">Zoeken</button>
        </form>
        <div class="navbar-nav" style="margin-left: auto">
            <div class="loginbutton">
                <button type="button" class="btn btn-default">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="<?php if(isset($_SESSION["loggedin"])) { if($_SESSION["loggedin"]) { echo "logout.php"; } else { echo "logout.php"; } } else { echo "login.php"; }?>"><?php if(isset($_SESSION["loggedin"])) { if($_SESSION["loggedin"]) { echo "logout"; } else { echo "logout"; } } else { echo "login"; }?><span class="sr-only">(current)</span></a>
                </button>
            </div>

            <div class="nav-item">
                <a class="nav-link text-center" href="verlanglijst.php<?php  if(isset($_SESSION["user_id"])){$db = new wwic_db; $w = $db->userWishlists($_SESSION["user_id"]); print("?w=".$w["wishlist_id"]);}?>"><i class="fa fa-heart navbarIcon"></i></a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="winkelwagen.php">
                    <i class="fa fa-shopping-cart navbarIcon"></i>
                </a>
            </div>
        </div>
</nav>

