<main role="main">

    <section class="text-center landing-ad cjumbotron">
        <div class="container transparent-background">
            <h1 class="white-text halloween-font">Tijd voor halloween</h1>
            <p><a href="#" class="btn btn-light my-2 halloween-font">Ga naar de aanbieding</a></p>
        </div>
    </section>

    <section class="text-header">
            <h1 class=" text-center">Aanbiedingen</h1>
        </div>
    </section>

    <section>
        <div class="container margin-top-botom">
            <div class="row text-center">
                <?php $sales = $wwi->get_sales(); for($i =0; $i < 4; $i++): $discount =  ($sales["" . $i .""]["UnitPrice"] - $sales["" . $i .""]["RecommendedRetailPrice"]) / $sales["" . $i .""]["RecommendedRetailPrice"] * 100; ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $sales["" . $i .""]["StockItemName"] . " - " . substr($discount, 1, -13) . "%" ?></h5>
                            <h5 class="card-title"><?= "€" . $sales["" . $i .""]["UnitPrice"] ?></h5>
                            <a href="#" class="btn btn-primary">Bekijk product</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section class="text-center feelinglucky cjumbotron">
        <div class="container transparent-background">
            <h1 class="jumbotron-heading white-text">I'm feeling lucky</h1>
            <p><a href="#" class="btn btn-light my-2">GO</a></p>
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
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Limited Stock</li>
                        <li class="list-group-item">Halloween Fun</li>
                        <li class="list-group-item">Comfortable</li>
                        <li class="list-group-item">Long Battery Life</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">So Realistic</li>
                        <li class="list-group-item">Vintage</li>
                        <li class="list-group-item">Radio Control</li>
                        <li class="list-group-item">Realistic Sound</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Comedy</li>
                        <li class="list-group-item">USB Powered</li>
                    </ul>
                </div>
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
                <?php $sales = $wwi->get_best_sellers(); for($i =0; $i < 4; $i++): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $sales["" . $i .""]["StockItemName"] ?></h5>
                                <h5 class="card-title"><?= "€" . $sales["" . $i .""]["RecommendedRetailPrice"] ?></h5>
                                <a href="#" class="btn btn-primary">Bekijk product</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

</main>

