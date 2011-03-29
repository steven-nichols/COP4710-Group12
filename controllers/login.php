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
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
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
            // The validation failed, so try again
            $this->session->keep_flashdata('redirect');
            $this->load->view('login_form');
        }
        else {
            $name = $this->input->post('Name', TRUE);
            $password = $this->input->post('password');

            // Try to authenticate
            $success = $this->Login_model->authenticate($name, $password);
            if($success)
            {
                $dest = $this->session->flashdata('redirect');
                if($dest)
                    redirect($dest);
                else
                    redirect("/");
            }
            else {
                $this->load->view('login_fail');
            }
        }
    }
   
    function logout(){
        $this->Login_model->logout();
        echo "Successfully logged out.";
    }
}
?>
