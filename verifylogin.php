<?php

class VerifyLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('reviewmodel', '', TRUE);
    }

    function index() {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
        
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->load->view('admin_login');
        } else {
            //Go to private area
		//$id = $this->session->userdata('id'); $username = $this->session->userdata('username');
            redirect('index.php/sessioncreate', 'refresh');
            //$this->load->view('uploader');
        }
    }

    function check_database($password) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('name');

        //query the database
        $result = $this->reviewmodel->login($username, $password);

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->admin_id,
                    'username' => $row->name
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

}

?>
