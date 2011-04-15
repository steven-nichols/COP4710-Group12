<?php
/*
 * Controller for the Account creation page.
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
        $num_users = $this->User_model->get_user_count(1);
        $users = $this->User_model->get_user_range(0,$num_users,1);
        $childid = $this->input->post('childID');
        if($childid)
            $transactions = $this->Item_model->get_transaction_child($childid);
        else
            $transactions = $this->Item_model->get_transactions();
        
        $data = array (
            "picture" => $this->session->userdata['picture'],
            "users" => $users,
            "transactions" => $transactions
        );
        $this->load->view('transactionHistory', $data);
    }

  }
?>
