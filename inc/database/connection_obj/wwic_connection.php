<?php
class wwic_db {
    public $connectie = null;

    private function __construct (){
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
        return $this;
    }

    
    public static function connect (){
        return new wwic_db();
    }


    
    function __destruct(){
        mysqli_close($this->connectie);
    }
}
