<?php
/*
 * Controller for the Account creation page.
 */
class Transaction extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    function index(){
        $num_users = $this->User_model->get_user_count(1);
        $users = $this->User_model->get_user_range(0,$num_users,1);
        $data = array (
            "users" => $users
        ); 
        $this->load->view('transactionHistory', $data);
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
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[3]'
            ),
            array(
                'field' => 'pass_conf',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ),
            array(
                'field' => 'birthdate',
                'label' => 'Birthdate',
                'rules' => 'trim|callback_valid_date'
            )
        );
        $this->form_validation->set_rules($config);


        // First run or there were errors with the form
        if($this->form_validation->run() == FALSE)
        {
            // Add a new user
            $this->load->view('registration_form');
        }
        else // Form validation passed 
        {
            $first_name = $this->input->post('first_name', TRUE);
            $last_name = $this->input->post('last_name', TRUE);
            $password = $this->input->post('password');
            $birthdate = $this->input->post('birthdate', TRUE);
            $user_type = $this->input->post('user_type');
            $active = (bool)$this->input->post('active');
            if(!isset($active)) $active = false;
            $picture = $this->input->post('picture');

            // Attempt to add the new user to the database
            $success = $this->User_model->add_new_user($first_name, $last_name,
                $password, $birthdate, $user_type, $active, $picture);

            if($success)
            {
                $data = array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "picture" => $picture
                );
                $this->load->view('registration_success', $data);
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
        
        $userid = $this->input->post('userid');
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
            $first_name = $this->input->post('first_name', TRUE);
            $last_name = $this->input->post('last_name', TRUE);
            $password = $this->input->post('password');
            $birthdate = $this->input->post('birthdate', TRUE);
            $user_type = $this->input->post('user_type');
            $active = (bool)$this->input->post('active');
            if(!isset($active)) $active = false;
            $picture = $this->input->post('picture');

            // Change query slightly if user includes an updated password
            if($password)
                $changepasswd = true;
            else
                $changepasswd = false;

            $success = $this->User_model->modify_user((int)$userid, $first_name,
                $last_name, $password, $birthdate, $user_type, $active,
                $picture, $changepasswd);
        

            if($success)
            {
                $data = array(
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "picture" => $picture
                );
                $this->load->view('registration_success', $data);
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
