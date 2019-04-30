<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form'));
        $this->load->library('Template');
    }

	public function index()
	{
		if ( $this->session->userdata('logged_in') ) {
        	$session_data = $this->session->userdata('logged_in');
			$this->template->load_template("notifications",$session_data);
		} else {
				redirect("", 'refresh');
			}
	}


}
