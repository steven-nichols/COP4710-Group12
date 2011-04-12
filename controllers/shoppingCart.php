<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class order extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Item_model');
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
        
		$kids = $this->User_model->get_user_by_type('child');

		$num_items = $this->Item_model->get_item_count(1);
                $items = $this->Item_model->get_item_range(0,$num_items,1);
		
                $data = array(
                                        "users" => $kids,
					"listitems" => $items
					);

		$this->load->view('shoppingCart', $data);
	}
}
