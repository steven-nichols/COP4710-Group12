<?php

class Login extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Login_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    /*
     * Attempt to authenticate user. If sucessful, the user
     * is returned to the address in the 'redirect' field
     * of the session cookie.
     */
    function index()
    {
        //echo $this->session->flashdata('redirect');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|callback__authentication_check[password]'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);

        if($this->form_validation->run() == FALSE)
        {
            $this->session->keep_flashdata('redirect');
            $this->load->view('login_form');
        }
        else {
            // Run username through XSS filter
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');

            // Double check authentication
            $success = $this->Login_model->authenticate($username, $password);
            if($success)
            {
                $dest = $this->session->flashdata('redirect');
                if($dest)
                    redirect($dest);
                else
                    redirect("/");
            }
            else {
                echo "Invalid username/password";
            }
        }
    }
    
    function _authentication_check($username, $password){
        if($this->Login_model->authenticate($username, $password))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('_authentication_check', 'Incorrect username or password');
            return false;
        }
    }

    function logout(){
        $this->Login_model->logout();
        echo "Successfully logged out.";
    }
}
?>
