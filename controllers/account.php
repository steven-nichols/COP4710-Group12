<?php
/*
 * Controller for the Account creation page.
 */
class Account extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }
    function index(){
        $this->addmodify();
    }

    /*
     * $userid is the ID of the user to be modified.
     * If this is a new user then $userid should be null.
     */
    function addmodify($userid = null)
    {
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


        $this->load->helper(array('form', 'url'));
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
                'rules' => 'required|min_length[6]'
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
            if($userid == null){
                $this->load->view('registration_form');
            }
            else { // Modify existing user
                // pull user information from database
                $data = $this->User_model->get_user_data($userid);
                $this->load->view('registration_form', $data);
            }
        }
        else // Form validation passed 
        {
            $first_name = $this->input->post('first_name', TRUE);
            $last_name = $this->input->post('last_name', TRUE);
            $password = $this->input->post('password');
            $birthdate = $this->input->post('birthdate', TRUE);
            $user_type = $this->input->post('user_type');
            $active = $this->input->post('active');
            $picture = $this->input->post('picture');

            // Attempt to add the new user to the database
            if($userid == null) {
                $success = $this->User_model->add_new_user($first_name, $last_name,
                    $password, $birthdate, $user_type, $active, $picture);
            }
            else {
                $success = $this->User_model->modify_user($userid, $first_name,
                    $last_name, $password, $birthdate, $user_type, $active, $picture);
            }

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
            $arr = explode("/",$str);     // splitting the array
            $mm = (int)$arr[0];            // second element is month
            $dd = (int)$arr[1];            // third element is days
            $yyyy = (int)$arr[2];            // first element of the array is year
            
            if ( checkdate($mm, $dd, $yyyy) )
                return true;
         } 
        $this->form_validation->set_message('valid_date', 'Please enter date in mm/dd/yyyy format');
        return false;

    }  
}
?>
