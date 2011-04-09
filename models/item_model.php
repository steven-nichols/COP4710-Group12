<?php

class Item_model extends CI_Model {
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
     * \param $notavail Boolean, indicates if we want to return inactive items.  
     *        If omitted, FALSE is assumed,
     *
     * \return All found items in an array or null on failure.
     */
    function get_items_by_type($type, $notavail=0)
    {
        if($notavail){
            $sql = "SELECT * From `items` WHERE `type` = ?";
        } else {
            $sql = "SELECT * From `items` WHERE `type` = ? AND available = 1";
        }

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
     * \param $notavail Boolean indicating if we want to return information for 
     *        unavailable items.  FALSE is assumed if omitted.
     *
     * \return See description.
     */
    function get_item_count($notavail=0)
    {
        if($notavail){
            $sql = "SELECT COUNT(*) FROM `items`";
        } else {
            $sql = "SELECT COUNT(*) FROM `items` WHERE `available = 1";
        }
        
        $query = $this->db->query($sql);
        
        return $query->row_array();
    }
    
    /**
     * Returns information for a specified count of items, sorted by itemID, 
     * with a specified offset from the top of the list.
     *
     * \param $start The offset from the start of the list from which the 
     *        returned items are taken.
     * \param $count The number of items to return
     * \param $notavail Boolean indicating if we should return unavailable 
     *        items.  Assumed FALSE if omitted.
     *
     * \return The sorted range of items as an array, null on failure.
     */
    function get_item_range($start, $count, $notavail=0)
    {
        if($notavail){
            $sql = "SELECT * FROM `items` ORDER BY `itemID` LIMIT ?,  ?";
        } else {
            $sql = "SELECT * FROM `items` WHERE `available` = 1 ORDER BY 
                `itemID` LIMIT ?, ?";
        }
        
        $query = $this->db->query($sql, array($start=0, $count=30));

        if($query->num_rows > 0)
        return $query->result_array();

        return null;
    }

	/**
	* Returns items table, sorted by itemID.
	* \param $notavail Boolean indicating if we should return unavailable 
    *        items.  Assumed FALSE if omitted.
	* \return The table in array format, null on failure.
	*/
	function get_all_items($notavail=0)
	{
		if($notavail){
			$sql = "SELECT * FROM `items` ORDER BY `itemID`";
		}
		else{
			$sql = 	"SELECT * FROM `items` WHERE `available` = 1 ORDER BY `itemID`";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{		
			return null;
		}
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
     * \param $realcost The cost of the item in real money.  Decimal as xx.xx
     * \param $pointcost The cost of the item in CBCBucks. Integer values only.
     * \param $qty The current quantity of the item in inventory.
     * \param $minqty The quantity at which to warn the store supervisor to 
     *        purchase more of this item.  If this is unknown or undesired, 
     *        just set it to 0.
     * \param $picture The filename of the item's picture.  If the name isn't 
     *        known, either set this to "defaultitem.jpg" or omit it from the 
     *        function call.
     *
     * \return TRUE/FALSE on success/failure
     */
    function add_item($description, $supplier, $url, $partno, $type, 
        $available, $realcost, $pointcost, $qty, $minqty, $picture=
        'defaultitem.jpg')
    {
        $sql = "INSERT INTO `items` (`description`, `supplier`, `supplierurl`, 
            `partno`, `type`, `available`, `picture`, `realcost`, `pointcost`, 
            `qty`, `minqty`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        
       return $query = $this->db->query($sql, array($description, $supplier, 
        $url, $partno, $type, $available, $picture, $realcost, $pointcost, 
        $qty, $minqty));
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
     * \param $realcost The new or retained real cost
     * \param $pointcost The new or retained CBCBucks cost
     * \param $minqty The new or retained warning quantity
     * \param $picture The new or retained picture filename.  Omit from the 
     *        function call to reset the value to the default.
     *
     * \return TRUE/FALSE on success/failure
     */
    function modify_item($itemID, $description, $supplier, $url, $partno, 
        $type, $available, $realcost, $pointcost, $minqty, $picture=
        'defaultitem.jpg')
    {
        $sql = "UPDATE `items` SET `description` = ?, `supplier` = ?, 
            `supplierurl` = ?, `partno` = ?, `type` = ?, `available` = ?, 
            `picture` = ?, `realcost` = ?', `pointcost` = ?, `qty` = ?, 
            `minqty` = ? WHERE `itemID` = ?;";
        
        return $this->db->query($sql, array($description, $supplier, $url, 
            $partno, $type, $available, $picture, $realcost, $pointcost, 
            $minqty, $itemID));
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
        $sql = "UPDATE `items` SET `qty` = ? WHERE `itemID` = ?;";
        return $this->db->query($sql, array($qty, $itemID));   
    }


}
?>
