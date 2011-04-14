<?php
/*
 * Controller for the Account creation page.
 */
class Item extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->model('item_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    function index(){
       $this->add();
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
                'field' => 'realcost',
                'label' => 'Real Cost',
                'rules' => 'required'
            ),
            array(
                'field' => 'pointcost',
                'label' => 'Point Cost',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);


        // First run or there were errors with the form
        if($this->form_validation->run() == FALSE)
        {
            // Add a new
            $total_items = $this->item_model->get_item_count(1);
            $items = $this->item_model->get_item_range(0, $total_items);
            $data = array(
                "listitems" => $items,
                "img_path" => base_url()."images/"
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

            // Attempt to add the new user to the database
            $success = $this->item_model->add_item($description, $supplier, $url, $partno, $type, 
        $available, $realcost, $pointcost, $qty, $minqty, $picture);

            if($success)
            {
                $this->load->view('item_success');
            }
            else
            {
                echo "An error occured when trying to add/modify the account.";
            }
        }
    }

    /*
     * Modify an existing user. Only trusted helpers can modify accounts. 
     *
     * NOTE: The userid of the user to be modified must be passed as a POST variable 
     * called 'userid'.
     */
    function modify(){
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
        
        $itemid = $this->input->post('itemID');
        $redirect = $this->input->post('redirect');

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('
            <tr>
            <td></td>
            <td class="error">','</td>
            </tr>');

        // Do not force the user to update their password
        $config = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|trim|strip_tags|max_length[50]'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim|strip_tags|max_length[50]'
            ),
            array(
                'field' => 'birthdate',
                'label' => 'Birthdate',
                'rules' => 'trim|callback_valid_date'
            )
        );
        $this->form_validation->set_rules($config);


        // First run or there were errors with the form
        if($redirect || $this->form_validation->run() == FALSE)
        {
            // pull user information from database
            $data = $this->User_model->get_user_data($userid);
            $data['birthdate'] = $this->User_model->us_date($data['birthdate']);
            $this->load->view('registration_form', $data);
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
            $modreason = $this->input->post('txtModificationReason', TRUE);
            $moddesc = $this->input->post('txtModificationDescription', TRUE);
        
            $success = $this->item_model->modify_item((int)$itemid, 
                $description, $supplier, $url, $partno, $type, $available, 
                $realcost, $pointcost, $minqty, $picture);
        

            if($success)
            {
                $this->load->view('item_success');
            }
            else
            {
                echo "An error occured when trying to add/modify the account.";
            }
        }
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
