<?php
session_start();

class wwi_db  {
    public $connectie = null  ;

    private function __construct() {
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

        return $this;
        

    }

    public static function connect (){
        return new wwi_db();
    }

   


    function __destruct(){
        mysqli_close($this->connectie);
    }
}

