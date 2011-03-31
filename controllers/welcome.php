<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
	}

	function index()
	{
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }

        $this->load->view('home_view');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
