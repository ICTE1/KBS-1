<div class="container" style="margin-top: 10px; margin-bottom: 10px;">
    <h1>Winkelwagen</h1>
    <?php
    //test if there is a shopping cart
    if(isset($_SESSION["winkelWagen"]) && count($_SESSION["winkelWagen"]) != 0) {
        //print products from session
        foreach ($_SESSION["winkelWagen"] as $product => $aantal) {
            //get product info
            $data = $databaseWWI->productInfo($product);
            $prijs = $aantal * $data['RecommendedRetailPrice'];
            $prijsTot = $prijsTot + $prijs;
            //format numbers to amount of money
            $data["RecommendedRetailPrice"] = number_format($data["RecommendedRetailPrice"], 2, ",", ".");
            $prijs = number_format($prijs, 2, ",", ".");

            print('
            <div class="row product_card_card" ');

            //see if this is the last item, so it doesn't need a border
            $b = array_keys($_SESSION["winkelWagen"]);
            if ($product == end($b)) {
                print('style="border-bottom: 0px"');
            }
            //print content
            print('>
                <div class="col-2" >
                    <img class="img-fluid productThumbnail" src = "public/images/space 2.jpg" >
                </div >
                <div class="col-5" >
                    <div class="product_card_text" >
                        <p >
                            <b >' . $data["StockItemName"] . '</b ><br >
                    ' . $data["SearchDetails"] . '
                        </p >
                    </div >
                </div >
                <div class="col-5">
                <div style="position: absolute; bottom: 10px; right: 10px">
                    <form method="post" class="form-inline" style="display: inline-block">
                        aantal:
                        <input type="number" class="form-control m-1" name="aantal" style="width: 60px;" min="1" value="' . $aantal . '">
                        <input type="hidden" name="hiddenUpdate" value="' . $product . '">
                        <button type="submit" class="btn custom-button-primary" value="Update">Update</button>
                    </form>
                    <form method="post" class="form-inline" style="display: inline-block">
                        <input type="hidden" name="hiddenVerwijderen" value="' . $product . '">
                        <button type="submit" class="btn custom-button-primary"><i class="fa fa-trash-o"></i></button>
                    </form>
                    <div class="text-right">
                        Prijs per product: €' . $data["RecommendedRetailPrice"] . '
                        <br>
                        Prijs totaal: €' . $prijs . '
                    </div>
                </div>
                </div >
            </div>
                ');
        }
        //calculate and format prices
        $prijsVerzend = $prijsTot + 5;
        $prijsTot = number_format($prijsTot, 2, ",", ".");
        $prijsVerzend = number_format($prijsVerzend, 2, ",", ".");

        //print total amount and buttons (once)
        print("
        <div class='card' style='background-color: #353535'>
            <div class='card-body text-right'>
                Prijs artikelen: €".$prijsTot."
                <br>
                verzendkosten: €5,-
            </div>
            <div class='card-footer text-right'>
                <form> 
                <h4>Totaal: €".$prijsVerzend."   <input type='submit' class='btn custom-button-primary' value='betalen'></h4>
                </form>
            </div>
        </div>
        </div>
        ");
    }
    //if cart is empty:
    else{
        print("<h2>Uw winkelwagen is leeg.</h2>");
    }

    ?>
</div>