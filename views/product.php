
<main>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">

                    <div class="row padding-product">

                        <div class="col-sm-12 no-padding">
                            <a href="public/images/productinvulling/<?= $content[0]['url'] ?>" class="fancybox" rel="ligthbox">
                                <img  src="public/images/productinvulling/<?= $content[0]['url'] ?>" class="zoom img-fluid "  alt="product-img-1">
                            </a>
                        </div>

                        <?php for($i = 1; $i < 3; $i++): ?>

                            <div class="col-sm-4 no-padding">
                                <a href="" class="fancybox" rel="ligthbox">
                                    <img  src="public/images/productinvulling/<?= $content[$i]['url'] ?>" class="zoom img-fluid "  alt="product-img">
                                </a>
                            </div>

                        <?php endfor; ?>

                        <div class="col-sm-4 no-padding">
                            <a href="" class="fancybox" rel="ligthbox">
                                <?= $content[3]['url'] ?>
                            </a>
                        </div>

                    </div>


                </div>

                <div class="col-sm-4" style="padding-top: 1%;">
                    <h1> <?php print($product['StockItemName']) ?></h1>
                    <p> <?php if($product['MarketingComments'] != "") {
                        print($product['MarketingComments']);
                        }else {
                        print('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dictum tempus justo, id vehicula mauris porttitor eget. Suspendisse tristique urna sit amet lectus sollicitudin cursus. Pellentesque porttitor ultrices dolor ac egestas. Phasellus at pulvinar tellus, eu hendrerit sem. Phasellus accumsan gravida scelerisque.');
                        } ?></p>
                    <p><?php print("Tags: " . substr($product['tags'], 2, -2)); ?></p>
                </div>
                <div class="col-sm-4" style="padding-top: 5%;">
                    <h1 class="center">€ <?php print($product['RecommendedRetailPrice'])?></h1>
                    
                    <form method="post">
                        <input type="hidden" value="1" name="aantal">
                        <input type = "hidden" name = "Product" value="<?= $id?>">
                        <button type="submit" class="btn-margin btn custom-button-primary btn-lg btn-block " name="message" value="Nu kopen">Nu kopen<i class="fa fa-shopping-cart"></i></button>
                    </form>


                    <form method="post" action="selecteer_lijst.php">
                        <input type ="hidden" name = "product" value="<?= $id?>">
                        <button type="submit" class="btn-margin btn custom-button-primary btn-lg btn-block " name="action" value="ProductPage">In verlanglijst<i class="fa fa-heart"></i></button>
                    </form>



                    <button type="button" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" id="sharebutton" class="btn-margin btn custom-button-primary btn-lg btn-block ">Delen <i class="fa fa-share"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                    <div class="col-sm-6">
                        <h1>Reviews</h1>
                        <div class="row">

                            <?php for($i = 0; $i < count($reviews); $i++): ?>
                            <div class="col-sm-3">
                                <img src="public/images/space%202.jpg" alt="placeholder profile picture" class="user-photo align-content-center"><br>
                                <h5 class="center"><?= $reviews[$i]["name"]; ?></h5>
                            </div>
                            <div class="col-sm-9">

                                <?php $stars = 0; for($x = 0; $x < $reviews[$i]["rating"]; $x++): ?>
                                    <i class="no-margin-bottom fa fa-star"></i>
                                <?php $stars++; endfor; ?>
                                <?php $empty_stars = 5 - $stars; for($z = 0; $z < $empty_stars; $z++): ?>
                                    <i class="no-margin-bottom fa fa-star-o"></i>
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
                         
                            <div class="col-sm-9">
                                <form method="POST" action="product.php">
                                <input type="hidden" name="product" value="<?=$id?>">
                                    <div class="form-group">
                                        <label for="naam">Naam:</label>
                                        <input type="text" name="name" class="form-control" id="naam" placeholder="John" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="stars">Beoordeling:</label>
                                        <select name="stars" class="form-control" id="stars" required>
                                            <option disabled selected value> -- selecteer een optie -- </option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="reviewtext">Review:</label>
                                        <textarea name="reviewtext" class="form-control" id="reviewtext" rows="4" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail:</label>
                                        <input name="email" type="email" class="form-control" id="email" placeholder="John@doe.nl" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" name="review" class="btn btn-primary">Plaatsen</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <h1>Aanvullende informatie</h1>
                            <?php

                            $characters = array("\"", "{", "}");
                            $replace = (" ");
                            $arr = ($product["CustomFields"]);
                            $array = str_replace($characters,$replace,$arr);

                            $split_array = str_split($array);

                            foreach($split_array as $split_ar) {
                                print($split_ar);
                                if($split_ar == ",") {
                                    print("<br>");
                                }
                            }
                            ?>
                        <br><br>
                        <h1>Trademarks:</h1>
                        <img src="public/images/trademark1.png" style="max-width: 25%;" alt="trademark1" />
                        <img src="public/images/trademark2.png" style="max-width: 25%;" alt="trademark2" />
                    </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h1 class="jumobotron-heading text-center">Ook wat voor u?</h1>
        </div>
    </section>

    <section>
        <div class="container" style="margin-bottom: 2%;">
            <div class="row text-center">
                <?php for($i =0; $i < count($similar); $i++):
                    $content = $products_db->get_product_photo($similar["" . $i .""]["StockItemID"]); ?>
                    <div class="col-md-3">
                        <div class="card ccart">
                            <img src="public/images/productinvulling/<?= $content[0]['url'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php if(strlen($similar["" . $i .""]["StockItemName"]) >= 35) {
                                        $name = substr($similar["" . $i .""]["StockItemName"], 0, 32);
                                        echo $name . "..."; }
                                    else {
                                        echo $similar["" . $i .""]["StockItemName"];
                                    } ?>
                                </h5>
                                <h5 class="card-title"><?= "€" . $similar["" . $i .""]["RecommendedRetailPrice"] ?></h5>
                                <a href="product.php?p=<?= $similar["" . $i .""]["StockItemID"] ?>" class="btn btn-primary custom-button-primary">Bekijk product</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

</main>


