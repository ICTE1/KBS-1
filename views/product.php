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
                        print('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dictum tempus justo, id vehicula mauris porttitor eget. Suspendisse tristique urna sit amet lectus sollicitudin cursus. Pellentesque porttitor ultrices dolor ac egestas. Phasellus at pulvinar tellus, eu hendrerit sem. Phasellus accumsan gravida scelerisque.');
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
                    <div class="col-6">
                        <h1>Reviews</h1>
                        <div class="row">
                            <?php for($i = 0; $i < count($reviews); $i++): ?>
                            <div class="col-3">
                                <img src="public/images/space 2.jpg" class="user-photo align-content-center"><br>
                                <h5 class="center"><?= $reviews[$i]["name"]; ?></h5>
                            </div>
                            <div class="col-9">
                                <?php for($x = 0; $x < $reviews[$i]["rating"]; $x++): ?>
                                    <i class="no-margin-bottom fa fa-star"></i>
                                <?php endfor; ?>
                                <br>
                                <?php if(strlen($reviews["" . $i .""]["review"]) >= 178) {
                                    $short_review = substr($reviews["" . $i .""]["review"], 0, 175);
                                    echo $short_review . "..."; }
                                else {
                                    echo $reviews["" . $i .""]["review"];
                                } ?>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="col-6">

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
            <div class="row text-center">
                <?php for($i =0; $i < 4; $i++): ?>
                    <div class="col-md-3">
                        <div class="card ccart">
                            <img src="public/images/space 2.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">

                                    <?php if(strlen($similar["" . $i .""]["StockItemName"]) >= 35) {
                                        $name = substr($similar["" . $i .""]["StockItemName"], 0, 32);
                                        echo $name . "..."; }
                                    else {
                                        echo $sales["" . $i .""]["StockItemName"];
                                    } ?>
                                </h5>
                                <h5 class="card-title"><?= "€" . $similar["" . $i .""]["RecommendedRetailPrice"] ?></h5>
                                <a href="#" class="btn btn-primary custom-button-primary">Bekijk product</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

</main>


