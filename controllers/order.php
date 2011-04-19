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
        $helperid = $this->session->userdata('userid');
        if(!$this->User_model->is_trusted_helper($helperid)){
            die("Only people with 'Trusted Helper' level permissions can perform transactions");
        }

        $kids = $this->User_model->get_user_by_type('child');

        $num_items = $this->Item_model->get_item_count(1);
        $items = $this->Item_model->get_item_range(0,$num_items,1);

        $data = array(
            "picture" => $this->session->userdata['picture'],
            "users" => $kids,
            "listitems" => $items
        );

        $this->load->view('shoppingCart', $data);
    }

    /**
     * Collect the information from the shopping cart page and
     * display it on the checkout page. If all goes well, i.e.,
     * the child has enough money to pay, then the order will 
     * be send to process() for processing.
     */
    function checkout(){
        $num_items = $this->input->post('itemsTotal');
        $userid = $this->input->post('userID');

        $totalcost = 0;
        $items = array();
        for($i = 0; $i < $num_items; $i++){
            $items[$i] = array(
                'itemid' => $this->input->post('HitemNumber'.$i),
                'qty' => $this->input->post('Hquantity'.$i),
                'pointCost' => $this->input->post('Hcost'.$i),
                'description' => $this->input->post('Hdescription'.$i)
            );
            $totalcost += $items[$i]['pointCost'] * $items[$i]['qty'];
        }
        $data = array(
            "picture" => $this->session->userdata['picture'],
            'userID' => $userid,
            'listitems' => $items,
            'totalcost' => $totalcost
        );
        $this->load->view('checkout', $data);
    }

    /**
     * Final step in ordering. Updates the DB to reflect purchase.
     */
    function process(){
        $userid = $this->input->post('userID');
        $num_items = $this->input->post('itemTotal');
        $totalcost = $this->input->post('totalCost');

        // Record the transaction
        $transID = $this->Item_model->new_transaction($userid, $num_items, $totalcost);
        
        // Record the items that make up the transaction
        for($i = 0; $i < $num_items; $i++){    
            $itemID = $this->input->post('itemNumber'.$i);
            $pointCost = $this->input->post('cost'.$i);
            $qty = $this->input->post('quantity'.$i);

            $oldinfo = $this->Item_model->get_item_by_id($itemID);
            $oldqty = $oldinfo['qty'];
            $newqty = $oldqty - $qty;

            $this->Item_model->add_trans_item($itemID, $transID, $pointCost, $qty); 
            $this->Item_model->modify_item_qty($itemID,$newqty);
            
            
            
        }

        $this->load->view('checkout_success');
    }


}
