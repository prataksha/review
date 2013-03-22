<?php
class SessionCreate extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index(){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data['username'] = $session_data['username'];
            $this->load->view('uploader', $data);
        } else {
            //If no session, redirect to login page
            redirect('index.php/review', 'refresh');
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('index.php/sessioncreate', 'refresh');
    }

}
?>
