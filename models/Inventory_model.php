<?php

class Inventory_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

	//returns the whole inventory table
	function get_all_items()
	{
		$sql = "SELECT * FROM items";	
		$query = $this->db->query($sql);

		return $query->result();
	}
}
?>
