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


    function get_products_by_category($category_name) {
        $query = "
        SELECT DISTINCT i.StockItemID AS identifier,  i.StockItemName ProductName , g.StockGroupName Category, i.UnitPrice Price
        FROM  stockitemstockgroups v 
        JOIN stockitems i  ON v.StockItemID = i.StockItemID
        JOIN stockgroups g ON v.StockGroupID = g.StockGroupID
        WHERE g.StockGroupName = ?
        ";


        $stmt = mysqli_prepare($this->connectie ,$query);
        mysqli_stmt_bind_param($stmt, 's', $category_name);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }

    function search_products ($search_term , $sort_by = null){
        // build db query 
        $query = "
        SELECT stockitems.StockItemID AS identifier, stockitems.StockItemName AS ProductName ,stockitems.UnitPrice AS Price, g.StockGroupName AS Category
        FROM stockitems 
        JOIN stockitemstockgroups v  ON v.StockItemID = stockitems.StockItemID
        JOIN stockgroups g ON v.StockGroupID = g.StockGroupID
        WHERE  
        stockitems.StockItemName LIKE ?
        OR
        stockitems.SearchDetails LIKE ?
        GROUP BY stockitems.StockItemName
        ";

        if ( $sort_by != null ){
            
            switch($sort_by){
                case 'naame':
                    $query .= ' ORDER BY stockitems.StockItemName';
                break;
                case 'prijs':
                    $query .= 'ORDER BY stockitems.UnitPrice';
                break;
                default;
                    // add nothing to query
                break;
            }
           
        }
       
        
        $search_term = '%'. $search_term .'%';
        $statement = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($statement , 'ss' , $search_term, $search_term);

        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    function productInfo($product){
        
        $query = "SELECT StockItemID, StockItemName, MarketingComments, tags, RecommendedRetailPrice, CustomFields, SearchDetails  FROM stockitems WHERE StockItemID =?;";

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
    function get_product_amount() {

        $result = mysqli_query ($this->connectie , "SELECT COUNT(StockItemID) amount FROM stockitems");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }

    function get_categories(){        
        $result = mysqli_query ($this->connectie , "SELECT StockGroupName AS category_name FROM stockgroups");
        $rows = mysqli_fetch_all ($result, MYSQLI_ASSOC );
        mysqli_free_result($result);
        return $rows;
    }

    function get_similar_products($product) {

        $query = "SELECT * FROM stockitems I WHERE I.stockItemID IN (SELECT stockItemID FROM stockitems J WHERE J.CustomFields LIKE CONCAT('%', (SELECT Tags FROM stockitems WHERE StockItemID = ? ), '%') AND I.stockItemID <> ?) ORDER BY rand() LIMIT 4";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "ii", $product, $product);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $similar = mysqli_fetch_all($result,MYSQLI_ASSOC);
        return($similar);

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
     * get user wishlists
     *
     * @param user id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with wishlist_id's made by user
     */
    function userWishlists($user){
        $query = "SELECT wishlist_id FROM wishlist WHERE customer_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $id = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($id as $record => $wishlist){
            $wishlists[] = $wishlist["wishlist_id"];
        }
        return($wishlists);
    }

    /**
     * add wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return none
     */
    function add_wishlist($user, $name){
        if($name == ""){
            $query = "INSERT INTO wishlist(customer_id) VALUE (?)";
            $stmt = mysqli_prepare($this->connectie, $query);
            mysqli_stmt_bind_param($stmt, "i", $user);
        }
        else{
            $query = "INSERT INTO wishlist(customer_id, name) VALUES (?, ?)";
            $stmt = mysqli_prepare($this->connectie, $query);
            mysqli_stmt_bind_param($stmt, "is", $user, $name);
        }

        mysqli_stmt_execute($stmt);
    }

    /**
     * delete wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return none
     */
    function delete_wishlist($wishlist){
        $query = "DELETE FROM wishlist WHERE wishlist_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
    }

    /**
     * test if product is in wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with info on a wishlist: owner, name, shared
     */
    function wishlistTest($wishlist, $product_id)
    {
        $query = "SELECT * FROM wishlist_product WHERE wishlist_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $return = false;
        foreach ($info as $key => $products) {
            if ($products["product_id"] == $product_id) {
                $return = true;
                break;
            }
        }
        return ($return);
    }

    /**
     * get info of wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with info on a wishlist: owner, name, shared
     */
    function wishlistInfo($wishlist){
        $query = "SELECT * FROM wishlist WHERE wishlist_id = ?";
        $stmt = mysqli_prepare($this->connectie, $query);
        mysqli_stmt_bind_param($stmt, "i", $wishlist);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $info = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return($info);
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

        $query = "SELECT product_id FROM wishlist_product WHERE wishlist_id = ? ORDER BY date_added";

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
     * add product to wishlist
     *
     * @param wishlist id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return none
     */
    function wishlistAdd($wishlist, $product){
        $query = "INSERT INTO wishlist_product(wishlist_id, product_id) VALUES (?, ?)";
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
        $query = "SELECT id, username, password, activated FROM user WHERE username = ?";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_array($result, MYSQLI_ASSOC);

    }
    /**
     * Get the reviews from 1 specific product
     *
     * @param product_id - the id of the product to get the reviews from
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     * @return rows in an associative array
     */
    function get_product_reviews($product_id) {
        $query = "SELECT name, rating, review, photo FROM review WHERE product_id = ? ORDER BY created_at DESC LIMIT 3";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "s", $product_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }
    /**
     * Insert a review in every product
     *
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     */
    function  fill_reviews() {

        $names = array("Emma","Olivia","Ava","Sophia","Isabella","Mia","Charlotte","Abigail","Emily","Harper","Amelia","Evelyn","Elizabeth","Sofia","Madison","Avery","Ella","Scarlett","Grace","Chloe","Victoria","Riley","Aria","Lily","Aubrey","Zoey","Penelope","Lillian","Addison","Layla","Natalie","Camila","Hannah","Brooklyn","Zoe","Nora","Leah","Savannah","Audrey","Claire","Eleanor","Skylar","Ellie","Samantha","Stella","Paisley","Violet","Mila","Allison","Alexa","Anna","Hazel","Aaliyah","Ariana","Lucy","Caroline","Sarah","Genesis","Kennedy","Sadie","Gabriella","Madelyn","Adeline","Maya","Autumn","Aurora","Piper","Hailey","Arianna","Kaylee","Ruby","Serenity","Eva","Naomi","Nevaeh","Alice","Luna","Bella","Quinn","Lydia","Peyton","Melanie","Kylie","Aubree","Mackenzie","Kinsley","Cora","Julia","Taylor","Katherine","Madeline","Gianna","Eliana","Elena","Vivian","Willow","Reagan","Brianna","Clara","Faith","Ashley","Emilia","Isabelle","Annabelle","Rylee","Valentina","Everly","Hadley","Sophie","Alexandra","Natalia","Ivy","Maria","Josephine","Delilah","Bailey","Jade","Ximena","Alexis","Alyssa","Brielle","Jasmine","Liliana","Adalynn","Khloe","Isla","Mary","Andrea","Kayla","Emery","London","Kimberly","Morgan","Lauren","Sydney","Nova","Trinity","Lyla","Margaret","Ariel","Adalyn","Athena","Lilly","Melody","Isabel","Jordyn","Jocelyn","Eden","Paige","Teagan","Valeria","Sara","Norah","Rose","Aliyah","Mckenzie","Molly","Raelynn","Leilani","Valerie","Emerson","Juliana","Nicole","Laila","Makayla","Elise","Mariah","Mya","Arya","Ryleigh","Adaline","Brooke","Rachel","Eliza","Angelina","Amy","Reese","Alina","Cecilia","Londyn","Gracie","Payton","Esther","Alaina","Charlie","Iris","Arabella","Genevieve","Finley","Daisy","Harmony","Anastasia","Kendall","Daniela","Catherine","Adelyn","Vanessa","Brooklynn","Juliette","Julianna","Presley","Summer","Destiny","Amaya","Hayden","Alana","Rebecca","Michelle","Eloise","Lila","Fiona","Callie","Lucia","Angela","Marley","Adriana","Parker","Alexandria","Giselle","Alivia","Alayna","Brynlee","Ana","Harley","Gabrielle","Dakota","Georgia","Juliet","Tessa","Leila","Kate","Jayla","Jessica","Lola","Stephanie","Sienna","Josie","Daleyza","Rowan","Evangeline","Hope","Maggie","Camille","Makenzie","Vivienne","Sawyer","Gemma","Joanna","Noelle","Elliana","Mckenna","Gabriela","Kinley","Rosalie","Brynn","Amiyah","Melissa","Adelaide","Malia","Ayla","Izabella","Delaney","Cali","Journey","Maci","Elaina","Sloane","June","Diana","Blakely","Aniyah","Olive","Jennifer","Paris","Miranda","Lena","Jacqueline","Paislee","Jane","Raegan","Lyric","Lilliana","Adelynn","Lucille","Selena","River","Annie","Cassidy","Jordan","Thea","Mariana","Amina","Miriam","Haven","Remi","Charlee","Blake","Lilah","Ruth","Amara","Kali","Kylee","Arielle","Emersyn","Alessandra","Fatima","Talia","Vera","Nina","Ariah","Allie","Addilyn","Keira","Catalina","Raelyn","Phoebe","Lexi","Zara","Makenna","Ember","Leia","Rylie","Angel","Haley","Madilyn","Kaitlyn","Heaven","Nyla","Amanda","Freya","Journee","Daniella","Danielle","Kenzie","Ariella","Lia","Brinley","Maddison","Shelby","Elsie","Kamila","Camilla","Alison","Ainsley","Ada","Laura","Kendra","Kayleigh","Adrianna","Madeleine","Joy","Juniper","Chelsea","Sage","Erin","Felicity","Gracelyn","Nadia","Skyler","Briella","Aspen","Myla","Heidi","Katie","Zuri","Jenna","Kyla","Kaia","Kira","Sabrina","Gracelynn","Gia","Amira","Alexia","Amber","Cadence","Esmeralda","Katelyn","Scarlet","Kamryn","Alicia","Miracle","Kelsey","Logan","Kiara","Bianca","Kaydence","Alondra","Evelynn","Christina","Lana","Aviana","Dahlia","Dylan","Anaya","Ashlyn","Jada","Kathryn","Jimena","Elle","Gwendolyn","April","Carmen","Mikayla","Annalise","Maeve","Camryn","Helen","Daphne","Braelynn","Carly","Cheyenne","Leslie","Veronica","Nylah","Kennedi","Skye","Evie","Averie","Harlow","Allyson","Carolina","Tatum","Francesca","Aylin","Ashlynn","Sierra","Mckinley","Leighton","Maliyah","Annabella","Megan","Margot","Luciana","Mallory","Millie","Regina","Nia","Rosemary","Saylor","Abby","Briana","Phoenix","Viviana","Alejandra","Frances","Jayleen","Serena","Lorelei","Zariah","Ariyah","Jazmin","Avianna","Carter","Marlee","Eve","Aleah","Remington","Amari","Bethany","Fernanda","Malaysia","Willa","Liana","Ryan","Addyson","Yaretzi","Colette","Macie","Selah","Nayeli","Madelynn","Michaela","Priscilla","Janelle","Samara","Justice","Itzel","Emely","Lennon","Aubrie","Julie","Kyleigh","Sarai","Braelyn","Alani","Lacey","Edith","Elisa","Macy","Marilyn","Baylee","Karina","Raven","Celeste","Adelina","Matilda","Kara","Jamie","Charleigh","Aisha","Kassidy","Hattie","Karen","Sylvia","Winter","Aleena","Angelica","Magnolia","Cataleya","Danna","Henley","Mabel","Kelly","Brylee","Jazlyn","Virginia","Helena","Jillian","Madilynn","Blair","Galilea","Kensley","Wren","Bristol","Emmalyn","Holly","Lauryn","Cameron","Hanna","Meredith","Royalty","Sasha","Lilith","Jazmine","Alayah","Madisyn","Cecelia","Renata","Lainey","Liberty","Brittany","Savanna","Imani","Kyra","Mira","Mariam","Tenley","Aitana","Gloria","Maryam","Giuliana","Skyla","Anne","Johanna","Myra","Charley","Tiffany","Beatrice","Karla","Cynthia","Janiyah","Melany","Alanna","Lilian","Demi","Pearl","Jaylah","Maia","Cassandra","Jolene","Crystal","Everleigh","Maisie","Anahi","Elianna","Hallie","Ivanna","Oakley","Ophelia","Emelia","Mae","Marie","Rebekah","Azalea","Haylee","Bailee","Anika","Monica","Kimber","Sloan","Jayda","Anya","Bridget","Kailey","Julissa","Marissa","Leona","Aileen","Addisyn","Kaliyah","Coraline","Dayana","Kaylie","Celine","Jaliyah","Elaine","Lillie","Melina","Jaelyn","Shiloh","Jemma","Madalyn","Addilynn","Alaia","Mikaela","Adley","Saige","Angie","Dallas","Braylee","Elsa","Emmy","Hayley","Siena","Lorelai","Miah","Royal","Tiana","Elliot","Kori","Greta","Charli","Elliott","Julieta","Alena","Rory","Harlee","Rosa","Ivory","Guadalupe","Jessie","Laurel","Annika","Clarissa","Karsyn","Collins","Kenia","Milani","Alia","Chanel","Dorothy","Armani","Emory","Ellen","Irene","Adele","Jaelynn","Myah","Hadassah","Jayde","Lilyana","Malaya","Kenna","Amelie","Reyna","Teresa","Angelique","Linda","Nathalie","Kora","Zahra","Aurelia","Kalani","Rayna","Jolie","Sutton","Aniya","Jessa","Laylah","Esme","Keyla","Ariya","Elisabeth","Marina","Mara","Meadow","Aliza","Zelda","Lea","Elyse","Monroe","Penny","Lilianna","Lylah","Liv","Scarlette","Kadence","Ansley","Emilee","Perla","Annabel","Alaya","Milena","Karter","Avah","Amirah","Leyla","Livia","Chaya","Wynter","Jaycee","Lailah","Amani","Milana","Lennox","Remy","Zariyah","Clare","Hadlee","Kiera","Rosie","Alma","Kaelyn","Eileen","Jayden","Martha","Noa","Christine","Ariadne","Natasha","Emerie","Tatiana","Joselyn","Joyce","Salma","Amiya","Audrina","Kinslee","Jaylene","Analia","Erika","Lexie","Mina","Patricia","Dulce","Poppy","Aubrielle","Clementine","Lara","Amaris","Milan","Aliana","Kailani","Kaylani","Maleah","Belen","Simone","Whitney","Elora","Claudia","Gwen","Rylan","Antonella","Khaleesi","Arely","Princess","Kenley","Itzayana","Karlee","Paulina","Laney","Bria","Chana","Kynlee","Astrid","Giovanna","Lindsey","Sky","Aryanna","Ayleen","Azariah","Joelle","Nala","Tori","Noemi","Breanna","Emmeline","Mavis","Amalia","Mercy","Tinley","Averi","Aiyana","Alyson","Corinne","Leanna","Madalynn","Briar","Jaylee","Kailyn","Kassandra","Kaylin","Nataly","Amia","Yareli","Cara","Taliyah","Thalia","Carolyn","Estrella","Montserrat","Zaylee","Anabelle","Deborah","Frida","Zaria","Kairi","Katalina","Nola","Erica","Isabela","Jazlynn","Paula","Faye","Louisa","Alessia","Courtney","Reign","Ryann","Stevie","Heavenly","Lisa","Roselyn","Raina","Adrienne","Celia","Estelle","Marianna","Brenda","Kathleen","Paola","Hunter","Ellis","Hana","Lina","Raquel","Aliya","Iliana","Kallie","Emmalynn","Naya","Reina","Wendy","Landry","Barbara","Casey","Karlie","Kiana","Rivka","Kenya","Aya","Carla","Dalary","Jaylynn","Sariah","Andi","Romina","Dana","Danica","Ingrid","Kehlani","Zaniyah","Alannah","Avalynn","Evalyn","Sandra","Veda","Hadleigh","Paityn","Abril","Ciara","Holland","Lillianna","Kai","Bryleigh","Emilie","Carlee","Judith","Kristina","Janessa","Annalee","Zoie","Maliah","Bonnie","Emmaline","Louise","Kaylynn","Monserrat","Nancy","Noor","Vada","Aubriella","Maxine","Nathalia","Tegan","Aranza","Emmie","Brenna","Estella","Ellianna","Kailee","Ailani","Caylee","Zainab","Zendaya","Jana","Julianne","Ellison","Sariyah","Lizbeth","Susan","Alyvia","Jewel","Marjorie","Marleigh","Nathaly","Sharon","Yamileth","Zion","Mariyah","Lyra","Belle","Yasmin","Kaiya","Maren","Marisol","Vienna","Calliope","Hailee","Rayne","Tabitha","Anabella","Blaire","Giana","Milania","Paloma","Amya","Novalee","Harleigh","Ramona","Rhea","Aadhya","Miya","Desiree","Frankie","Sylvie","Jasmin","Moriah","Rosalyn","Kaya","Joslyn","Tinsley","Farrah","Aislinn","Halle","Madyson","Micah","Arden","Bexley","Ari","Aubri","Ayana","Cherish","Davina","Anniston","Riya","Adilynn","Ally","Amayah","Harmoni","Heather","Saoirse","Azaria","Alisha","Nalani","Maylee","Shayla","Briley","Elin","Lilia","Ann","Antonia","Aryana","Chandler","Esperanza","Lilyanna","Alianna","Luz","Meilani");

        for ($i=1; $i<228; $i++) {
            $k = array_rand($names);
            $name = $names[$k];

            $star = rand(1, 5);
            $content = file_get_contents('https://loripsum.net/api/1/short');
            $mail = $name . "@gmail.com";

            $this->insert_review($i, $name, $star, $content, $mail);
        }
    }
    /**
     * Insert a review into the database
     *
     * @param product_id - the id of the product to insert a review into
     * @param r_name - name of the reviewer
     * @param review - the review text
     * @param stars - the review stars (rating)
     * @param r_email - the e-mail of the reviewer
     *
     * @throws No_exceptions cause to lazy to program
     * @author Dylan Roubos
     */
    function insert_review($product_id, $r_name, $stars, $review, $r_email) {
        $query = "INSERT INTO review (product_id, name, rating, review, email) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "isiss", $product_id, $r_name, $stars, $review, $r_email);
        mysqli_stmt_execute($stmt);
    }


    function get_product_photo($product_id) {

        $query = "SELECT C.url, C.photo FROM content C JOIN content_r CR ON C.content_id = CR.content_id WHERE CR.stockitem_id = ?;";

        $stmt = mysqli_prepare($this->connectie, $query);

        mysqli_stmt_bind_param($stmt, "s", $product_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $content =  mysqli_fetch_all($result, MYSQLI_ASSOC);

        if($content == NULL ) {
            $new_number = $product_id + 1;
            $content = $this->get_product_photo($new_number);

        }
        return $content;
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
        $_SESSION["user_id"] = NULL;

    }
    function __destruct(){
        mysqli_close($this->connectie);
    }
}
