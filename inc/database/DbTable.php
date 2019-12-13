<?php 
abstract class dbTable {
    private $wwi = null ;
    private $wwic = null;

    public function __construct (){
        $this->wwi  = wwi_db::connect();
        $this->wwic = wwic_db::connect();
    }

    /**
     * Execute a query to the correct database 
     * 
     * @param dbname        - Name of the connection you want to use
     * @param query         - You'd like to execute
     * @param result        - Variable to store the result in 
     * @param params        - Optional parameters (for prepared statements)
     * @param param_types   - Optional datatypes of parameters given as string (see mysqli docs)
     */
    public function query ( string $dbname, $query, &$result, $param_types = null, $params = null ) {
        
        $connectionToUse = $this->dbConnection($dbname);
        
        if ($params === null && $param_types === null ){
            // just execute like a regular query.
           try {
            $result = $this->simple_query($connectionToUse->connectie, $query);
            return true;
           }
           catch (Exception $e) {
            return false;
           }
        }

        try {
            $result = $this->prepared_query($connectionToUse->connectie, $query, $param_types, $params);
         
            return true;
        }
        catch ( Exception $e){
            return false;
        }
    }

    /**
     * Executes a simple query using the mysqli api 
     * 
     * @param connectionToUse   - mysqli_connection_object we'd like to use 
     * @param query             - Query string we'd like to execute 
     */
    private function simple_query ($connectionToUse , $query) {
        $a = mysqli_query ($connectionToUse, $query);
           
        $result = mysqli_fetch_all ($a , MYSQLI_ASSOC);
        mysqli_free_result($a); 

        return $result;
       
    }

    /**
     * Executes a prepared statement using the mysqli api 
     * 
     * @param connectionToUse   - mysql_connection_object we'd like to use
     * @param query             - Query string we'd like to execute
     * @param param_types       - Datatypes of the params in string format ( see mysqli docs)
     * @param params            - parameters of the prepared statement
     */
    private function prepared_query ($connectionToUse , $query, $param_types, $params ) {
        $stmt = mysqli_prepare($connectionToUse , $query );
            
        mysqli_stmt_bind_param($stmt , $param_types, ...$params);
        
        mysqli_stmt_execute($stmt);
        
        $a = mysqli_stmt_get_result($stmt);


        if ($a == false) {
            die("Get result went wrong!");
            return NULL;
        }

        $result = mysqli_fetch_all($a, MYSQLI_ASSOC);


        return $result;
    }
    
    /**
     * Chooses which connection we'd like to use
     * 
     * @param dbname    - String representing the database connection we want to use
     * @throws Exception - If no matching connection object is found a general exception will be thrown
     */
    private function dbConnection ($dbname) {
        switch ($dbname){
            case ("wwi"):
                return $this->wwi;
            break;
            case ("wwic"):
               return $this->wwic;
            break;
            default :
                throw Exception("Unknown database connection");
            break;
        }
    }


    public function __destruct(){
        $this->wwi = null;
        $this->wwic = null;

    }
}