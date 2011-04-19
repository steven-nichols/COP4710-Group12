<?php

class Item_model extends CI_Model {
    // Class constants
    const TYPE_TOY = "toy";
    const TYPE_ACCESSORY = "accessory";
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('select_helper');
    }

    function get_item_types(){
        $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = 'items'
                AND COLUMN_NAME = 'type'";
        
        $query = $this->db->query($sql);

        if($query->num_rows == 1){
            $str = $query->row()->COLUMN_TYPE;
            // Remove the leading "enum(" and the trailing ")"
            $str = substr($str, 5, -1);
            // Remove single quoates
            $str = str_replace("'", "", $str);

            $types = explode(',', $str);
            return $types;
        }
        else
            return null;
    }

    function get_mod_types(){
        $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = 'manualAdj'
                AND COLUMN_NAME = 'reason'";
        
        $query = $this->db->query($sql);

        if($query->num_rows == 1){
            $str = $query->row()->COLUMN_TYPE;
            // Remove the leading "enum(" and the trailing ")"
            $str = substr($str, 5, -1);
            // Remove single quoates
            $str = str_replace("'", "", $str);

            $types = explode(',', $str);
            return $types;
        }
        else
            return null;
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
        $query = $this->db->query($sql, array($itemID));

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
        $result = $query->row_array(); 
        return (int)$result['COUNT(*)'];
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
        return $query->result();

        return null;
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
        $type, $available, $realcost, $pointcost, $qty, $minqty, $picture=
        'defaultitem.jpg')
    {
        $sql = "UPDATE `items` SET `description` = ?, `supplier` = ?, 
            `supplierurl` = ?, `partno` = ?, `type` = ?, `available` = ?, 
            `picture` = ?, `realcost` = ?, `pointcost` = ?, `qty` = ?, 
            `minqty` = ? WHERE `itemID` = ?;";
        
        return $this->db->query($sql, array($description, $supplier, $url, 
            $partno, $type, $available, $picture, $realcost, $pointcost, 
            $qty, $minqty, $itemID));
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

    function record_manual_adjustment($userid, $itemid, $description, $reason){
        $sql = "INSERT INTO `manualAdj` (userID, itemID, date, description, reason)
            VALUES (?, ?, CURDATE(), ?, ?)";
        $this->db->query($sql, array($userid, $itemid, $description, $reason));
    }

    /**
     * Create a new entry in the tranaction table.
     * Returns the transactionID of the new row
     */
    function new_transaction($userID, $numItems, $totalPointCost){
        // Make sure that this is actually a new transaction
        $sql = "SELECT transactionID from `transactions` WHERE userID = ? AND 
            date = CURDATE()";
        $result = $this->db->query($sql, array($userID));
        if($result->num_rows != 0){
            // Get the id of this transaction
            $transID = $result->row()->transactionID;

            // Update the number of items in the transaction
            $sql = "UPDATE `transactions` SET totalItems=totalItems+?, 
                    total=total+? WHERE userID = ? AND date = CURDATE()";
            $this->db->query($sql, array($numItems, $totalPointCost, $userID));

            // Return the transaction id
            return $transID;
        }

        $sql = "INSERT INTO `transactions` (userID, date, totalItems, total)
            VALUES (?, CURDATE(), ?, ?)";

        $this->db->query($sql, array($userID, $numItems, $totalPointCost));
        return $this->db->insert_id();
    }

    function add_trans_item($itemID, $transID, $price, $qty){
        $sql = "INSERT INTO `transItems` (itemID, transactionID, salePrice, qty)
            VALUES (?, ?, ?, ?)";

        return $this->db->query($sql, array($itemID, $transID, $price, $qty));
    }


    function get_transaction_items($transID)
    {
        $sql = "SELECT * FROM `transItems` WHERE transactionID = ?";
        $query = $this->db->query($sql, array($transID));

        if($query->num_rows > 0)
            return $query->result();

        return null;
    }

    function get_transactions()
    {
        $sql = "SELECT * FROM `transactions` ORDER BY `date`";
        $query = $this->db->query($sql);

        if($query->num_rows > 0){
            foreach ($query->result() as $row){
                $items = $this->get_transaction_items($row->transactionID);
                $row->items = $items;
             //   print_r($row);
            }
            return $query->result();
        }

        return null;
    }

    function get_transaction_child($userid)
    {
        $sql = "SELECT * FROM `transactions` WHERE userID = ? ORDER BY `date`";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows > 0){
            foreach ($query->result() as $row){
                $items = $this->get_transaction_items($row->transactionID);
                $row->items = $items;
             //   print_r($row);
            }
            return $query->result();
        }

        return null;
    }

    function get_transaction_range($start=0, $count=30)
    {
        $sql = "SELECT * FROM `transactions` ORDER BY `transactionID` LIMIT ?,  ?";
        $query = $this->db->query($sql, array($start, $count));

        if($query->num_rows > 0){
            foreach ($query->result() as $row){
                $items = $this->get_transaction_items($row->transactionID);
                $row->items = $items;
             //   print_r($row);
            }
            return $query->result();
        }

        return null;
    }
}
?>
