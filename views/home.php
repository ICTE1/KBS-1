<main role="main">

    <section class="text-center landing-ad cjumbotron">
        <div class="container transparent-background">
            <h1 class="white-text halloween-font big-header">Tijd voor halloween</h1>
            <form method="GET" action="products.php">
                <button type="submit" name="s" value="halloween" class="btn btn-light my-2 halloween-font custom-button-big">Ga naar de aanbieding</button>
            </form>
        </div>
    </section>

    <section class="text-header">
            <h1 class=" text-center">Aanbiedingen</h1>
    </section>

    <section>
        <div class="container margin-top-botom">
            <div class="row text-center">
               <?php print_sales();?>
            </div>
        </div>
    </section>

    <section class="text-center feelinglucky cjumbotron">
        <div class="container transparent-background">
            <h1 class="jumbotron-heading white-text big-header">I'm feeling lucky</h1>
            <?php $products = new Products();$amount = $products->get_product_amount(); ?>
            <form action="product.php?p=<?= rand(0, $amount[0]['amount']); ?>" method="post">
                <button type="submit" name="your_name" value="your_value" class="btn btn-light my-2 custom-button-big">GO</button>
            </form>

        </div>
    </section>

    <section class="text-header">
        <div class="container ">
            <h1 class="jumobotron-heading text-center">Categorieën</h1>
        </div>
    </section>

    <section>
        <div class="container margin-top-botom">
            <div class="row">
                <?php 
                print_categories();
                ?>
            </div>
        </div>
    </section>

    <section class="text-header">
        <div class="container">
            <h1 class="jumobotron-heading text-center">Bestsellers</h1>
        </div>
    </section>

    <section>
        <div class="container margin-top-botom">
            <div class="row text-center">
                <?php 
                    $sales = $products->get_best_sellers();
                    for($i =0; $i < 4; $i++):
                ?>
                    <div class="col-md-3">
                        <div class="card ccart">
                            <img src="<?php print ( image_url . $products->get_product_photo ($sales[$i]["StockItemID"])[0]["url"] ) ;?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $sales[$i]["StockItemName"] ?></h5>
                                <h5 class="card-title"><?= "€" . $sales[$i]["RecommendedRetailPrice"] ?></h5>
                                <a href="product.php?p=<?php print( $sales[$i]['StockItemID']); ?>" class="btn btn-primary custom-button-primary">Bekijk product</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

</main>

