<?php


class Wishlist extends DbTable{

     /**
     * get user wishlists
     *
     * @param user id
     *
     * @throws No_exceptions cause to lazy to program
     * @author Jelle Wiersma
     * @return array with wishlists made by user
     */
    function userWishlists($user){
        $query = "SELECT wishlist_id FROM wishlist WHERE customer_id = ? LIMIT 1";
       
        $result = null;
        self::query('wwic', $query, $result, 'i', [$user]);
        
        return $result;
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
        $result = null;
        self::query ('wwic', $query, $result, 'i', [$wishlist]);
        return $result;
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

        $stock_item_ids = null;
        self::query('wwic', $query, $stock_item_ids , 'i', [$wishlist]);


        $products = array();
        foreach($stock_item_ids as $key => $col){
            $products = (new Products())->productInfo($col["product_id"]);
        }

        return $products;

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
        $result = null;
        self::query('wwic', $query, $result, 'ii', [$wishlist, $product] );
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
        $result = null;
        self::query ('wwic', $query, $result , 'ii', [$wishlist, $product]);

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

        $result = null;
        self::query ('wwic', $query, $result, 'i', [$wishlist]);
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

        $result = null;
        self::query ('wwic', $query, $result , 'i', [$wishlist]);
    }


}