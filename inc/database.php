<?php
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
    //Hier nog even prepared statement van maken
    /**
     * Checks if username exists in database
     *
     * @param name - name to check in database
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return Boolean
     */
    function check_if_user_exists($name) {

        $result = mysqli_query ($this->connectie , "SELECT * FROM user WHERE username = '$name'");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        if(empty($rows)) { return FALSE; } else { return TRUE;}

    }
    //Hier nog even prepared statement van maken
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

         mysqli_query($this->connectie, "INSERT INTO user (username, password) VALUES ('$name', '$password')");

    }
    //Hier nog even prepared statement van maken
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
        $result = mysqli_query ($this->connectie , "SELECT id, username, password FROM user WHERE username = ('$username')");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }
    function __destruct(){
        mysqli_close($this->connectie);
    }
}