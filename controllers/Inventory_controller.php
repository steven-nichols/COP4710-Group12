<?php

class Inventory_controller extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model->('Inventory_model');
		$this->load->model->('User_model');
 		$this->load->helper(array('form'));
		$this->load->library->session();
    

	function index()
	{
		// Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }

		$userData = $this->User_model->get_user_data($userid);
		$userImage = $userData->'picName';
		
		$items = $this->Inventory_model->get_all_items;
		$listitems = array(
					"itemNumber" => -1;
					"purchaseLocation" => "";
					"realCost" => -1;
					"pointCost" => -1;
					"description" => "";
				        "quantity" => -1;
					);

		foreach($items->result() as $item){
			$listitems->itemNumber = item->id;
			$listitems->purchaseLocation = item->supplierURL;
			$listitems->realCost = item->realCost;
			$listitems->pointCost = item->pointCost;
			$listitems->description = item->description;
			$listitems->quantity = item->qty;
		}
		endforeach;

		$this->load->view->Inventory_view(array($userImage, $listitems));
	}
}
?>
