<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once "vendor/autoload.php";

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
        self::query('wwic', $query, $result, 's',  [$username] );

        return $result ? true : false;

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
    function create_user($name, $email, $password) {
        $query = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        
        self::query('wwic', $query, $result , 'sss',  [$name, $email, $password]);

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

        self::query('wwic', $query, $result, 's', [$username] );
        

        return $result;

    }
    function insert_discount_code($user_id, $discount, $email){

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $code = $this->generate_code($permitted_chars, 10);

        $query = "INSERT INTO discount VALUES (?, ?, ?, ?)";
        $result = null;

        self::query('wwic', $query, $result, 'siii', [$code, $discount, 0, $user_id] );

        $this->mail($code, $email);
    }

    function generate_code($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }
    function apply_discount($code) {
        $query = "SELECT * FROM discount WHERE action_code = ?;";

        $result = NULL;

        self::query('wwic', $query, $result, 's', [$code] );

        if(empty($result)) {
            return $result;
        }

        $discount = $result[0]["discount"];

        return $discount;
    }

    function mail($code, $email) {

        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP

        $mail->isSMTP();

        //Enable SMTP debugging
        // SMTP::DEBUG_OFF = off (for production use)
        // SMTP::DEBUG_CLIENT = client messages
        // SMTP::DEBUG_SERVER = client and server messages
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';

        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption mechanism to use - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'worldwideimporters1@gmail.com';
        //Password to use for SMTP authentication
        $mail->Password = 'test.nl19';
        //Set who the message is to be sent from
        $mail->setFrom('worldwideimporters1@gmail.com', 'Wide World Importers');
        //Set an alternative reply-to address
        $mail->addReplyTo('worldwideimporters1@gmail.com', 'Wide World Importers');
        //Set who the message is to be sent to
        $mail->addAddress($email, $email);
        //Set the subject line
        $mail->Subject = 'Jouw aanmeldings kortingscode!';

        $mail->Body = 'Beste nieuwe klant, <br><br> Als bonus voor jouw registratie hierbij een code met 10% korting! <br><b>' . $code . '</b><br><br>Met vriendelijke groet, <br>het WWI team.';

        $mail->AltBody = 'Hier had een code moeten staan. Neem contact op met de helpdes.';
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
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