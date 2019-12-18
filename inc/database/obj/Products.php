<?php 

class Products extends DbTable{
    function get_products_by_category($category_name) {
        $query = "
        SELECT DISTINCT i.StockItemID AS identifier,  i.StockItemName ProductName , g.StockGroupName Category, i.UnitPrice Price
        FROM  stockitemstockgroups v 
        JOIN stockitems i  ON v.StockItemID = i.StockItemID
        JOIN stockgroups g ON v.StockGroupID = g.StockGroupID
        WHERE g.StockGroupName = ?
        ";

        $result = null;
        self::query('wwi', $query, $result, 's', [$category_name]);

        
      
        return $result == null ? []: $result;
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
    
        $result = null;
        self::query('wwi', $query , $result, 'ss', [$search_term, $search_term]);

        return $result == null ? [] : $result;
    }



    function productInfo($product){
        $query = "SELECT StockItemID, StockItemName, MarketingComments, tags, RecommendedRetailPrice, CustomFields, SearchDetails  FROM stockitems WHERE StockItemID =?;";

        $result = null;
        
        self::query('wwi', $query, $result, 'i', [$product]);
        return $result;

    }


    function get_product_photo($product_id) {

        $query = "SELECT C.url, C.photo FROM content C JOIN content_r CR ON C.content_id = CR.content_id WHERE CR.stockitem_id = ?;";

        $result = null;

        self::query ('wwic', $query, $result, 's', [$product_id]);

        $joe = array(
            0 => array (
                "url" => "74.jpg",
                "photo" => 1
            ),
            1 => array (
                "url" => "74.jpg",
                "photo" => 1
            ),
            2 => array (
                "url" => "74.jpg",
                "photo" => 1
            ),
            3 => array (
                "url" => "<iframe src=\"https://www.youtube.com/embed/x46dUiWDGfA\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>",
                "photo" => 0
            )
        );
       if($result == NULL ) {
           return $joe;

       }
        return $result;
    }


    function get_product_amount() {
        $query = "SELECT COUNT(StockItemID) amount FROM stockitems";
        
        $result = null;
        self::query ('wwi', $query , $result );
        
        return $result;
    }

    function get_categories(){        
        $query = "SELECT StockGroupName AS category_name FROM stockgroups";

        $result = null;
        self::query ('wwi', $query , $result);

        return $result;
    }

    function get_similar_products($product) {
        $query = "SELECT * FROM stockitems I WHERE I.stockItemID IN (SELECT stockItemID FROM stockitems J WHERE J.CustomFields LIKE CONCAT('%', (SELECT Tags FROM stockitems WHERE StockItemID = ? ), '%') AND I.stockItemID <> ?) ORDER BY rand() LIMIT 4";
        
        $result = null;
        self::query('wwi', $query, $result, 'ii', [$product, $product] );

        return $result;

    }

    function get_sales() {
        $query =  "SELECT StockItemID, StockItemName, UnitPrice, RecommendedRetailPrice FROM stockitems WHERE tags LIKE '%limited%' ORDER BY rand() LIMIT 5";
        
        $result = null; 
        self::query('wwi', $query , $result);
        
        return $result;
    }

    function get_best_sellers() {
            $query = "SELECT PL.StockItemID, SI.StockItemName, SI.RecommendedRetailPrice, COUNT(*) aantal FROM purchaseorderlines PL JOIN stockitems SI ON PL.StockItemID = SI.StockItemID GROUP BY PL.StockItemID ORDER BY aantal DESC LIMIT 4";
            
            $result = null;
            self::query('wwi', $query, $result);

            return $result;
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
     
        $result = null;
        self::query ('wwic', $query, $result, 's', [$product_id]);
        return $result;
    }

}