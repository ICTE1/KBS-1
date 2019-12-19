<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <form class='betaalgegevens' method="post" action="betaalpagina.php">
                <h2>Uw gegevens</h2>

                <?php if (!isset($_SESSION['loggedin'])) { ?>
                Volledige naam:
                <input type="text" name="Name" pattern="^[a-zA-Z]{2,}[[:blank:]][a-zA-Z]{2,}$"  required>
                <?php } ?>
                E-mail adres:
                <input type="email" name="Mail" required>
                Telefoon nummer:
                <input type="text" name="Phone-number" pattern="^[0-9]{10}$" required>
                Postcode:
                <input type="text" name="Zip-code" pattern="^[0-9]{4}[a-zA-Z]{2}$" required>
                Huisnummer:
                <input type="number" name="House" pattern="[0-9]+" required>

                <hr>

                <h2>Betalen</h2>

                <select name="bank">
                    <option value="">Selecteer een bank</option>
                    <option value="">ABN AMRO</option>
                    <option value="">ING</option>
                    <option value="">RABOBANK</option>
                    <option value="">REGIO BANK</option>
                    <option value="">BUNQ</option>
                </select>

                <div class="btn-group">

                    <input type="submit" class="btn btn-primary" name="payment" value="Verder met Ideal">

                    <input type="submit" class="btn btn-primary" name="payment" value="Betaal met paypal">


                </div>
            </form>
            </div>
            <div class="col-sm-6">
                <div class="winkelwagen_preview">
                    <?php
                    if ( isset($_SESSION['winkelWagen'])){
                        $shopping_cart_content = $_SESSION['winkelWagen'];
                        /*
                         * Content looks like this:
                         *  [
                         *  productid => amount ..
                         * ]
                         */
                            print("
                                    <table class='table table-dark'> 
                                    <thead >
                                        <tr>
                                            <th scope='col'> Product </th>
                                            <th scope='col'> prijs </th>
                                            <th scope='col'> aantal </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ");

                            $total_price = 0;
                            foreach ( $shopping_cart_content as $itemId => $amount) {
                            $db = new Products();
                            $productInfo = $db->productInfo($itemId)[0];
                          
                            $total_price +=  ($productInfo['RecommendedRetailPrice'] * $amount);
                            print("
                            
                            
                            
                            <tr >
                                <td> ".$productInfo['StockItemName']." </td>
                                <td>€".$productInfo["RecommendedRetailPrice"]."</td>
                                <td> ".$amount." </td>
                
                            </tr>
                            
                            ");
                        }

                        print ("
                        <tr>
                            <th scope='row'> Verzendkosten </th>
                            <th>€ 5,00 </th>
                            <th></th>
                        </tr>
                        <tr >
                            <th scope='row'> Totaal </th>
                            <th>€ ".($total_price + 5)."</th>
                            <th></th>
                            
                
                        </tr>
                        </tbody>
                        </table>
                        ");

                    }else{
                        print("Niks in winkelwagen");
                    }
                    ?>
            </div>
        </div>
    </div>
</div>