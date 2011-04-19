<?php
/*
 * 
 */
class Transaction extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->model('Item_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    function index(){
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
        
        // Only helpers should be allowed to perform transactions.
        $helperid = $this->session->userdata('userid');
        if(!$this->User_model->is_helper($helperid)){
            die("Only people with 'Teen Helper' level and higher permissions can view histories.");
        }
    

        $num_users = $this->User_model->get_user_count(1);
        $users = $this->User_model->get_user_by_type('child',false);
        $childid = $this->input->post('childID');

        if($childid){
            $transactions = $this->Item_model->get_transaction_child($childid);
            $last30 = false;
        }else{
            #$transactions = $this->Item_model->get_transactions();
            $transactions = $this->Item_model->get_transaction_range(0,30);
            $last30 = true;
        }
        
        $data = array (
            "picture" => $this->session->userdata['picture'],
            "users" => $users,
            "child" => $this->User_model->get_user_data($childid),
            "transactions" => $transactions,
            "last30" => $last30
        );
        $this->load->view('transactionHistory', $data);
    }

  }
?>
