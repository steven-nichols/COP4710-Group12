<?php

class Login_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('User_model');
        $this->load->library('session');
    }

    /**
     * Returns true if the person browsing the site is a logged-in, registered 
     * user.
     *
     * \return TRUE if user has been authenticated, FALSE if they have not.
     */
    function is_logged_in(){
        return $this->session->userdata('logged_in');
    }

    /**
     * Checks whether the user has already been authenticated, if so, return 
     * immediately. Otherwise, redirect the user to the login page and loop 
     * until they are successfully authenticated.
     */
    function login(){
        $logged_in = is_logged_in();

        while(!$logged_in){
            $this->login_page();
            $logged_in = is_logged_in();
        }
    }

    /**
     * Attempt to authenticate user. If sucessful, it marks the user as 
     * 'logged_in' and places commonly used data like the name and userid into 
     * the user's cookie and returns true. Otherwise, return false.
     *
     * \param $name The name of the user used for authentication (e.i., a 
     *        username).
     * \param $password The password the user entered on the login page.
     *
     * \return TRUE if the user supplied credentials match an existing user in 
     *         the database and FALSE otherwise.
     */
    function authenticate($name, $password)
    {
        $userid = $this->User_model->password_match($name, $password);
        if($userid)
        {
            $user_data = $this->User_model->get_user_data($userid);
                
            $session_info = array(
                "userid" => $user_data['userID'],
                "first_name" => $user_data['first_name'],
                "last_name" => $user_data['last_name'],
                "picture" => $user_data['picture'],
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

    /**
     * Logs the user out by deleting their session.
     */
    function logout(){
        $this->session->sess_destroy();
    }
}
?>
