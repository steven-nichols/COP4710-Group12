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
    
    function add_item($description, $supplier, $url, $partno, $type, 
        $available, $picture, $realcost, $pointcost, $qty, $minqty)
    {
    //return TF
    }/
    
    function modify_item($itemID, $description, $supplier, $url, $partno, 
        $type, $available, $picture, $realcost, $pointcost, $minqty)
    {
    //return T/F
    }
    
    function modify_item_qty($itemID,$qty)
    {
    //return T/F
    }


}
?>
