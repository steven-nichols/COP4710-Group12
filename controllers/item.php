<?php
/*
 * Controller for the Account creation page.
 */
class Item extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->model('Item_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    function index(){
        $total_items = $this->Item_model->get_item_count(1);
        $items = $this->Item_model->get_item_range(0, $total_items);
        $data = array(
            "picture" => $this->session->userdata['picture'],
            "listitems" => $items,
            "img_path" => base_url()."pictures/items/"
        );
        $this->load->view('item_select', $data);
    }

    /*
     * Add a new user to the database. Only trusted helpers can perform this 
     * action.
     */
    function add(){
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
        // Only Trusted helpers should be allowed to Add/Modify accounts
        $helperid = $this->session->userdata('userid');
        if(!$this->User_model->is_trusted_helper($helperid)){
            die("Only people with 'Trusted Helper' level permissions can add ".
                "or modify items");
        }      


        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        $config = array(
             array(
                'field' => 'picture',
                'label' => 'Item Picture',
                'rules' => 'required'
            ),
            array(
                'field' => 'realCost',
                'label' => 'Real Cost',
                'rules' => 'required'
            ),
            array(
                'field' => 'pointCost',
                'label' => 'Point Cost',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);


        // First run or there were errors with the form
        if($this->form_validation->run() == FALSE)
        {
            // Add a new
            $item_types = $this->Item_model->get_item_types();
            $mod_types = $this->Item_model->get_mod_types();

            $data = array(
                "title" => "Add New Item",
                "picture" => $this->session->userdata['picture'],
                "itemtypes" => $item_types,
                "modtypes" => $mod_types

            );
            $this->load->view('addItem', $data);
        }
        else // Form validation passed 
        {
            $description = $this->input->post('description', TRUE);
            $supplier = $this->input->post('supplier', TRUE);
            $url = $this->input->post('supplierURL', TRUE);
            $partno = $this->input->post('partNo', TRUE);
            $type = $this->input->post('itemType', TRUE);
            $minqty = $this->input->post('minQty');
            $available = (bool)$this->input->post('available');
            $realcost = $this->input->post('realCost', TRUE);
            $pointcost = $this->input->post('pointCost', TRUE);
            $picture = $this->input->post('picture', TRUE);
            $qty = $this->input->post('quantity', TRUE);

            // Attempt to add the new user to the database
            $success = $this->Item_model->add_item($description, $supplier,
                $url, $partno, $type, $available, $realcost, $pointcost,
                $qty, $minqty, $picture);

            if($success)
            {
                $this->Item_model->record_manual_adjustment($userid, $itemid,
                    $moddesc, $modreason);
                $this->load->view('item_success');
            }
            else
            {
                echo "An error occured when trying to add the item.";
            }
        }
    }

    /*
     * Modify an existing user. Only trusted helpers can modify accounts. 
     *
     * NOTE: The userid of the user to be modified must be passed as a POST variable 
     * called 'userid'.
     */
    function modify($itemid){
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
        // Only Trusted helpers should be allowed to Add/Modify accounts
        $helperid = $this->session->userdata('userid');
        if(!$this->User_model->is_trusted_helper($helperid)){
            die("Only people with 'Trusted Helper' level permissions can add ".
                "or modify accounts");
        } 

        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('
            <tr>
            <td></td>
            <td class="error">','</td>
            </tr>');

        $config = array(
            array(
                'field' => 'modificationDescription',
                'label' => 'Modification Description',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);


        // First run or there were errors with the form
        if($this->form_validation->run() == FALSE)
        {
            // pull user information from database
            $item = $this->Item_model->get_item_by_id($itemid);
            $item_types = $this->Item_model->get_item_types();
            $mod_types = $this->Item_model->get_mod_types();

            $data = array(
                "title" => "Modify Item",
                "picture" => $this->session->userdata['picture'],
                "item" => $item,
                "itemtypes" => $item_types,
                "modtypes" => $mod_types
            );

            $this->load->view('addItem', $data);
        }
        else // Form validation passed 
        {
            $description = $this->input->post('description', TRUE);
            $supplier = $this->input->post('supplier', TRUE);
            $url = $this->input->post('supplierURL', TRUE);
            $partno = $this->input->post('partNo', TRUE);
            $type = $this->input->post('itemType', TRUE);
            $minqty = $this->input->post('minQty');
            $available = (bool)$this->input->post('available');
            $realcost = $this->input->post('realCost', TRUE);
            $pointcost = $this->input->post('pointCost', TRUE);
            $qty = $this->input->post('quantity', TRUE);
            $picture = $this->input->post('picture', TRUE);
            $modreason = $this->input->post('modificationReason', TRUE);
            $moddesc = $this->input->post('modificationDescription', TRUE);
        
            $success = $this->Item_model->modify_item($itemid, 
                $description, $supplier, $url, $partno, $type, $available, 
                $realcost, $pointcost, $qty, $minqty, $picture);
        

            if($success)
            {
                $this->Item_model->record_manual_adjustment($helperid, $itemid,
                    $moddesc, $modreason);

                $this->load->view('item_success');
            }
            else
            {
                echo "An error occured when trying to modify the item.";
            }
        }
    }

    function inventory(){
        // Make sure person is logged in
        $logged_in = $this->session->userdata('logged_in');
        if(!$logged_in){
            redirect('/login');
            exit();
        }
        // Only helpers should be allowed to view the inventory
        $helperid = $this->session->userdata('userid');
        if(!$this->User_model->is_helper($helperid)){
            die("Only people with 'Helper' level permissions can view ".
                "the inventory");
        } 

        $num_items = $this->Item_model->get_item_count(1);
        $items = $this->Item_model->get_item_range(0,$num_items,1);

        $data = array(
            "picture" => $this->session->userdata['picture'],
            "listitems" => $items
        );

        $this->load->view('inventory', $data);
    }

    /*
     * Validate a date. Uses PHP built-in date checking function.
     * Taken from: http://codeigniter.com/forums/viewthread/60881/
     */
    function valid_date($str)
    {
        $pattern = "((0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])[-](19|20)\d\d)"; 
        if ( preg_match($pattern, $str) == 0){
            $arr = explode("/",$str);
            $mm = (int)$arr[0];
            $dd = (int)$arr[1];
            $yyyy = (int)$arr[2];
            
            if ( checkdate($mm, $dd, $yyyy) )
                return true;
            else {
                $this->form_validation->set_message('valid_date', 'Not a valid date');
                return false;
            }
         } 
        $this->form_validation->set_message('valid_date', 'Please enter date in mm/dd/yyyy format');
        return false;
    } 
}
?>
