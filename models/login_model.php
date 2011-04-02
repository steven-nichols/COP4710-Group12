<?php

class Login_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->library('session');
    }
    
    function is_logged_in(){
        return $this->session->userdata('logged_in');
    }
     
    function login(){
        $logged_in = is_logged_in();

        while(!$logged_in){
            $this->login_page();
            $logged_in = is_logged_in();
        }
    }

    /*
     * Attempt to authenticate user. If sucessful, returns true.
     */
    function authenticate($name, $password)
    {
        $userid = $this->User_model->password_match($name, $password);
        if($userid)
        {
            $user_data = $this->User_model->get_user_data($userid);
                
            $session_info = array(
                "userid" => $user_data['userid'],
                "first_name" => $user_data['first_name'],
                "last_name" => $user_data['last_name'],
                "logged_in" => true
            );

            $this->session->set_userdata($session_info);
            
            return true;
        }
        else 
        {
            return false;
        }
    }

    function logout(){
        $this->session->sess_destroy();
    }
}
?>
