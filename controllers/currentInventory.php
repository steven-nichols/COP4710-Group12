<?php

class currentInventory extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model->('Item_model');
		$this->load->model->('User_model');
 		$this->load->helper(array('form'));
		$this->load->library->session();
    }

	function index()
	{
		// Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
		
		$items = $this->item_model->get_all_items(1);
		$listitems = array(
					'itemNumber' => -1;
					'purchaseLocation' => 'default location';
					'realCost' => -1;
					'pointCost' => -1;
					'description' => 'default description';
				    'quantity' => -1;
					);

		foreach($items as $item){
			$listitems['itemNumber'] = $item->id;
			$listitems['purchaseLocation'] = $item->supplierURL;
			$listitems['realCost'] = $item->realCost;
			$listitems['pointCost'] = $item->pointCost;
			$listitems['description'] = $item->description;
			$listitems['quantity'] = $item->qty;
		}
		endforeach;

		$this->load->view->inventory(array($userImage, $listitems));
	}
}
?>
