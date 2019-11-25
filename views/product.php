<main role="main">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card bg-dark text-white">
                        <img src="public/images/space 2.jpg" class="card-img" alt="product">
                    </div>
                </div>
                <div class="col-4">
                    <h1> <?php print($product['StockItemName']) ?></h1>
                    <p> <?php if($product['MarketingComments'] != "") {
                        print($product['MarketingComments']);
                        }else {
                        print('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dictum tempus justo, id vehicula mauris porttitor eget. Suspendisse tristique urna sit amet lectus sollicitudin cursus. Pellentesque porttitor ultrices dolor ac egestas. Phasellus at pulvinar tellus, eu hendrerit sem. Phasellus accumsan gravida scelerisque. Ut fringilla nunc sagittis velit lobortis maximus. Nullam quis neque diam. Etiam vitae viverra nibh. Integer diam velit, dictum eu mi ut, tincidunt accumsan ante. Sed sodales velit at pulvinar varius. Vivamus posuere ipsum nisi, eget dictum purus euismod ut. In hac habitasse platea dictumst.');
                        } ?></p>
                    <p><?php print("Tags: " . substr($product['tags'], 2, -2)); ?></p>
                </div>
                <div class="col-4">
                    <h1 class="center">€ <?php print($product['RecommendedRetailPrice'])?></h1>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Nu kopen <i class="fa fa-shopping-cart"></i></button>
                    <button type="button" class="btn btn-primary btn-lg btn-block">In verlanglijst <i class="fa fa-heart"></i></button>
                    <button type="button" class="btn btn-primary btn-lg btn-block ">Delen <i class="fa fa-share"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-6">

                    </div>
                    <div class="col-6">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container ">
            <h1 class="jumobotron-heading text-center">Ook wat voor u?</h1>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-3">

                    </div>
                    <div class="col-3">

                    </div>
                    <div class="col-3">

                    </div>
                    <div class="col-3">

                    </div>
                </div>
            </div>
        </div>
    </section>

</main>


