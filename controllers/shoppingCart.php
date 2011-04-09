<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class order extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
	}

	function index()
	{
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
        // Only Trusted helpers should be allowed to perform transactions.
        $userid = $this->session->userdata('userid');
        if(!$this->User_model->is_trusted_helper($userid)){
            die("Only people with 'Trusted Helper' level permissions can perform transactions");
        }
        
		$kids = $this->user_model->get_user_by_type(TYPE_CHILD);
		$users = array(
					'fname' => 'default first name';
					'lname' => 'default last name';
					);
	
		foreach($kids as $kid){
			$users['fname'] = $kid->fName;
			$users['lname'] = $item->lName;
		}
		endforeach;

		$items = $this->item_model->get_all_items;
		$listitems = array(
					'itemNumber' => -1;
					'purchaseLocation' => 'default location';
					'realCost' => -1;
					'pointCost' => -1;
					'description' => 'default description';
				    'quantity' => -1;
					);

		foreach($items as $item){
			$listitems['image'] = $item->supplierURL;
			$listitems['quantity'] = $item->qty;
			$listitems['itemNum'] = $item->id;
			$listitems['cost'] = $item->pointCost;
			$listitems['descrp'] = $item->description;
		}
		endforeach;

		$this->load->view('shoppingCart', array($users, $listitems));
	}
}
