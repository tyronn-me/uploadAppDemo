<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class VerifyLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->library('Template');
    } // function

    public function index() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        if ( $this->form_validation->run() == FALSE) {

	        $data["error"] = "Please check your credentials and try again";

	        $this->load->view("parts/header",$data);
			       $this->load->view('welcome_message', $data);
			          $this->load->view("parts/footer");

        } else {
	       $session_data = $this->session->userdata('logged_in');
           $this->template->load_template("home", $session_data);
        }

    } // function

    function check_database($password) {

        $email = $this->input->post('email');

        $result = $this->user->login($email, $password);

        if ( $result ) {

            $sess_array = array();
            foreach($result as $row) {

                $sess_array = array('id'=>$row->id, 'firstname'=>$row->firstname,'profilePic'=>$row->profilePic, 'email'=>$row->email, 'company'=>$row->company, 'status'=>$row->status);
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;

        } else {

            $this->form_validation->set_message('check_database', 'Invalid email or password');
            return false;

        }

    } // function

}

?>
