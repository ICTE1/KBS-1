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
                <?php 
                $sales = $wwi->get_sales();
                for($i =0; $i < 4; $i++): 
                    $discount =  ($sales[$i]["UnitPrice"] - $sales[$i]["RecommendedRetailPrice"]) / $sales[$i]["RecommendedRetailPrice"] * 100;
                  
                    $image_uri = $wwic->get_product_photo($sales[$i]['StockItemID']);
                ?>
                <div class="col-md-3">
                    <div class="card ccart">
                        <img src="<?php print(image_url . $image_uri[0]['url'] ); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">
                                                    <?php if(strlen($sales[$i]["StockItemName"]) >= 23) {
                                                    $name = substr($sales[$i]["StockItemName"], 0, 28);
                                                    echo $name . "..."; } elseif (strlen($sales[$i]["StockItemName"]) <= 23) {
                                                        echo $sales[$i]["StockItemName"] . "<br>";
                                                    }
                                                    else {
                                                        echo $sales[$i]["StockItemName"];
                                                    }
                                                    echo "<br><b><span class='text-attention'>" . substr($discount, 1, -13) . "% korting" ?></span></b></h5>
                            <h5 class="card-title"><?= "€" . $sales[$i]["UnitPrice"] ?></h5>
                            <a href="#" class="btn custom-button-primary">Bekijk product</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section class="text-center feelinglucky cjumbotron">
        <div class="container transparent-background">
            <h1 class="jumbotron-heading white-text big-header">I'm feeling lucky</h1>
            <?php $amount = $wwi->get_product_amount(); ?>
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
                    $sales = $wwi->get_best_sellers(); 
                    for($i =0; $i < 4; $i++):
                ?>
                    <div class="col-md-3">
                        <div class="card ccart">
                            <img src="<?php print ( image_url . $wwic->get_product_photo ($sales[$i]["StockItemID"])[0]["url"] ) ;?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $sales[$i]["StockItemName"] ?></h5>
                                <h5 class="card-title"><?= "€" . $sales[$i]["RecommendedRetailPrice"] ?></h5>
                                <a href="#" class="btn btn-primary custom-button-primary">Bekijk product</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

</main>

