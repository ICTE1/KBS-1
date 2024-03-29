<?php
session_start();

class wwi_db  {
    public $connectie = null  ;

    function __construct() {
        $config = json_decode(file_get_contents("conf/db.json"));

        $host = $config->world_wide_importers->host;
        $user = $config->world_wide_importers->user;
        $pass = $config->world_wide_importers->pass;
        $dbName = $config->world_wide_importers->dbname;

        $this->connectie =  mysqli_connect ( $host, $user , $pass , $dbName);

        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to the database." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        

    }

    function get_cities (){
        $result = mysqli_query ($this->connectie , "SELECT * FROM cities LIMIT 10");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }



    function productInfo($product){
        
        $query = "SELECT StockItemID, StockItemName, RecommendedRetailPrice, SearchDetails  FROM stockitems WHERE StockItemID =?;";

        $statement = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($statement, "i", $product);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        return mysqli_fetch_array($result,MYSQLI_ASSOC);


        //$result = mysqli_query($this->connectie, "SELECT  StockItemName, RecommendedRetailPrice, SearchDetails  FROM stockitems WHERE StockItemID = $product");
        //return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_sales() {

        $result = mysqli_query ($this->connectie , "SELECT StockItemID, StockItemName, UnitPrice, RecommendedRetailPrice FROM stockitems WHERE tags LIKE '%limited%' ORDER BY rand() LIMIT 5");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }

    function get_best_sellers() {
        $result = mysqli_query ($this->connectie , "SELECT PL.StockItemID, SI.StockItemName, SI.RecommendedRetailPrice, COUNT(*) aantal FROM purchaseorderlines PL JOIN stockitems SI ON PL.StockItemID = SI.StockItemID GROUP BY PL.StockItemID ORDER BY aantal DESC LIMIT 4");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }




    function __destruct(){
        mysqli_close($this->connectie);
    }
}

class wwic_db {
    public $connectie = null;

    function __construct (){
        $config = json_decode(file_get_contents("conf/db.json"));

        $host = $config->world_wide_importers_custom->host;
        $user = $config->world_wide_importers_custom->user;
        $pass = $config->world_wide_importers_custom->pass;
        $dbName = $config->world_wide_importers_custom->dbname;

    
        $this->connectie =  mysqli_connect ( $host, $user , $pass , $dbName);

        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to the database." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }

    /**
     * Checks if username exists in database
     *
     * @param name - name to check in database
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return Boolean
     */
    function check_if_user_exists($username) {
        $query = "SELECT * FROM user WHERE username = ?";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if($user === NULL) { return FALSE; } else { return TRUE;}

    }

    /**
     * get info of wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with records, each value is an array with columns and values per record.
     */
    function wishlistInfo($wishlist){
        $query = "SELECT * FROM wishlist WHERE wishlist_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $name = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return($name);
    }
    /**
     * get info of products on wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with records, each value is an array with columns and values per record.
     */
    function wishlistProducts($wishlist){

        $query = "SELECT product_id FROM wishlist_product WHERE wishlist_id = ? ORDER BY created_at";

        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $stock_item_id = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $wwi = new wwi_db();
        $products = array();
        foreach($stock_item_id as $key => $col){
            $products[] = $wwi->productInfo($col["product_id"]);
        }
        return($products);

    }

    /**
     * delete product from wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return none
     */
    function wishlistDelete($wishlist, $product){
        $query = "DELETE FROM wishlist_product WHERE wishlist_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "ii", $wishlist, $product);
        mysqli_stmt_execute($stmt);
    }

    /**
     * set wishlist to shared
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return nothing
     */
    function shareWishlist($wishlist) {

        $query = "UPDATE wishlist SET shared=1 WHERE wishlist_id = ?";

        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
    }

    /**
     * set wishlist to not shared
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return nothing
     */
    function unshareWishlist($wishlist) {

        $query = "UPDATE wishlist SET shared=0 WHERE wishlist_id = ?";

        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
    }


    /**
     * Creates user in database
     *
     * @param name - uses the name to create the user
     * @param password - hashed password to add to the account
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return none
     */
    function create_user($name, $password) {
        $query = "INSERT INTO user (username, password) VALUES (?, ?)";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "ss", $name, $password);
        mysqli_stmt_execute($stmt);

    }
    /**
     * Get user data from database
     *
     * @param username - the name of the user to get the data from
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return rows in an associative array
     */
    function get_user_data($username) {
        $query = "SELECT id, username, password FROM user WHERE username = ?";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_array($result, MYSQLI_ASSOC);

    }
    /**
     * Logout the user
     *
     * @param none
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return none
     */
    function logout() {
        $_SESSION["loggedin"] = NULL;
        $_SESSION["username"] = NULL;

    }
    function __destruct(){
        mysqli_close($this->connectie);
    }
}