<?php
class User extends DbTable  {

    /**
     * Checks if username exists in database
     * 
     * @param name - name to check in database
     * 
     * @throws No_exceptions - cause to lazy to program
     * @author Dylan Roubos
     * @return Boolean
     */
    public function check_if_user_exists ($username){
        $query = "SELECT * FROM user WHERE username = ?";

        $result = [];
        self::query('wwic', $query, $result );

        return $user ? true : false;

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
        
        self::query('wwic', $query, $result , 'ss',  [$name, $password]);

    }

       /**
     * Get user data from database
     *
     * @param username          - the name of the user to get the data from
     *
     * @throws No_exceptions    - cause to lazy to program
     * @author Dylan Roubos
     * @return rows in an associative array
     */
    function get_user_data($username) {
        $query = "SELECT id, username, password, activated FROM user WHERE username = ?";

        $result = NULL;

        self::query('wwic', $query, $result, 's', $username );


        return $result;

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
    public function logout() {
        $_SESSION["loggedin"] = NULL;
        $_SESSION["username"] = NULL;
        $_SESSION["user_id"] = NULL;

    }
   
}