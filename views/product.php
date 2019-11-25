<main role="main">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-4">

                    <div class="row padding-product">

                        <div class="col-12 no-padding">
                            <a href="https://images.pexels.com/photos/62307/air-bubbles-diving-underwater-blow-62307.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" class="fancybox" rel="ligthbox">
                                <img  src="https://images.pexels.com/photos/62307/air-bubbles-diving-underwater-blow-62307.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" class="zoom img-fluid "  alt="">

                            </a>
                        </div>
                        <div class="col-4 no-padding">
                            <a href="https://images.pexels.com/photos/38238/maldives-ile-beach-sun-38238.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"  class="fancybox" rel="ligthbox">
                                <img  src="https://images.pexels.com/photos/38238/maldives-ile-beach-sun-38238.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" class="zoom img-fluid"  alt="">
                            </a>
                        </div>

                        <div class="col-4 no-padding">
                            <a href="https://images.pexels.com/photos/158827/field-corn-air-frisch-158827.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="fancybox" rel="ligthbox">
                                <img  src="https://images.pexels.com/photos/158827/field-corn-air-frisch-158827.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="zoom img-fluid "  alt="">
                            </a>
                        </div>

                        <div class="col-4 no-padding">
                            <a href="https://images.pexels.com/photos/302804/pexels-photo-302804.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="fancybox" rel="ligthbox">
                                <img  src="https://images.pexels.com/photos/302804/pexels-photo-302804.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="zoom img-fluid "  alt="">
                            </a>
                        </div>

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


