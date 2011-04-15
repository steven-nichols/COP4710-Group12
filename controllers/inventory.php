<?php

class inventory extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

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
		$num_items = $this->Item_model->get_item_count(1);
        $items = $this->Item_model->get_item_range(0,$num_items,1);

        $data = array(
            "picture" => $this->session->userdata['picture'],
            "listitems" => $items
        );

        $this->load->view('inventory', $data);
    }
}
?>
