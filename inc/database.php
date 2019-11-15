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

    function get_cities(){
        $result = mysqli_query($this->connectie, "SELECT CityName FROM cities WHERE CityName LIKE '%a%' LIMIT 20");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function productInfo($product){
        
        $query = "SELECT  StockItemName, RecommendedRetailPrice, SearchDetails  FROM stockitems WHERE StockItemID =?;";

        $statement = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($statement, "i", $product);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        return mysqli_fetch_array($result,MYSQLI_ASSOC);
       
       
        //$result = mysqli_query($this->connectie, "SELECT  StockItemName, RecommendedRetailPrice, SearchDetails  FROM stockitems WHERE StockItemID = $product");
        //return mysqli_fetch_all($result, MYSQLI_ASSOC); 
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

    function __destruct(){
        mysqli_close($this->connectie);
    }
}