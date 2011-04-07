<?php

class User_model extends CI_Model {
    // Class constants
    const TYPE_TOY = "toy";
    const TYPE_ACCESSORY = "accessory";
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * Return information on an item by ID number
     *
     * \param $itemID The ID number to search for
     *
     * \return The information on the found item, as an array, or null on 
     *         failure.
     */
    function get_item_by_id($itemID)
    {
        $sql = "SELECT * FROM `items` WHERE `itemID` = ? LIMIT 1";
        $query = $this->db->query($sql, array($itemId));

        if($query->num_rows == 1)
            return $query->row_array();
        else
            return null;
    }

    /**
     * Return information on all items of a particular type.
     *
     * \param $type The type of item to search for.  Current values are listed 
     *        as constants at the top of the file.  Check the database for new 
     *        additions.
     *
     * \return All found items in an array or null on failure.
     */
    function get_items_by_type($type)
    {
        $sql = "SELECT * From `items` WHERE `type` = ?";
        $query = $this->db->query($sql, array($type));
        
        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return null;
        }
    }
    
    /**
     * Return a count of all items in the database.
     *
     * \return See above.
     */
    function get_item_count()
    {
    }
    
    /**
     * Returns information for a specified count of items, sorted by itemID, 
     * with a specified offset from the top of the list.
     *
     * \param $start The offset from the start of the list from which the 
     *        returned items are taken.
     * \param $count The number of items to return
     *
     * \return The sorted range of items as an array, null on failure.
     */
    function get_item_range($start, $count)
    {
    }
    
    /**
     * Add a new item to the database.
     * \param $description A brief text description of the item
     * \param $supplier The source of the item
     * \param $url The supplier's website or short message if they don't have 
     *        one.
     * \param $partno The supplier's part number or <=20 char notation if there 
     *        isn't one
     * \param $type The type of the item.  Avaiable values are listed as 
     *        constants at the top of the file.  Check the database for new 
     *        additions.
     * \param $available Boolean indicating if the item is available for 
     *        purchase in the CBCKids store.
     * \param $picture The filename of the item's picture.  If left empty, the 
     *        field will be set to the default value, "defaultitem.jpg"
     * \param $realcost The cost of the item in real money.  Decimal as xx.xx
     * \param $pointcost The cost of the item in CBCBucks. Integer values only.
     * \param $qty The current quantity of the item in inventory.
     * \param $minqty The quantity at which to warn the store supervisor to 
     *        purchase more of this item. Defaults to 0 when left blank.
     *
     * \return TRUE/FALSE on success/failure
     */
    function add_item($description, $supplier, $url, $partno, $type, 
        $available, $picture, $realcost, $pointcost, $qty, $minqty)
    {
    }
    
    /**
     * Modify an item already in the DB.  Since changes to qty happen 
     * frequently (when adding new transactions), that function is separate.  
     * See add_item() for more details on the fields.
     *
     * \param $itemID The item to modify
     * \param $description The new or retained description
     * \param $supplier The new or retained supplier name
     * \param $url The new or retained supplier url
     * \param $partno The new or retained supplier's part number
     * \param $type The new or retained item type
     * \param $available The new or retained availability
     * \param $picture The new or retained picture filename.  Leaving blank
     *        resets picture to the default
     * \param $realcost The new or retained real cost
     * \param $pointcost The new or retained CBCBucks cost
     * \param $minqty The new or retained warning quantity
     *
     * \return TRUE/FALSE on success/failure
     */
    function modify_item($itemID, $description, $supplier, $url, $partno, 
        $type, $available, $picture, $realcost, $pointcost, $minqty)
    {
    //return T/F
    }
    
    /**
     * Modify an item's quantity.  This is useful for transactions and manual 
     * changes, which don't touch any other infomation, so it is separate from 
     * the more general modify_item() function.
     *
     * \param $itemID The ID of the item being modified
     * \param $qty The new quantity to assign to the item.
     *
     * \return TRUE/FALSE on success/failure
     */
    function modify_item_qty($itemID,$qty)
    {
    }


}
?>
