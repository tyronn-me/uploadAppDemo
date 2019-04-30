<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
			$this->template->load_template("users",$session_data);
		} else {
				redirect("", 'refresh');
			}
	}

	public function user() {
		if ( $this->session->userdata('logged_in') ) {
        	$session_data = $this->session->userdata('logged_in');
			$this->template->load_template("users",$session_data);
		} else {
				redirect("", 'refresh');
			}
	}

	public function userUpdate()
	{

		$email = $_POST['email'];
		$query = $this->db->query("SELECT * FROM users WHERE email = '$email'");
		foreach ($query->result_array() as $row) {
			$firstname = $row['firstname'];
		}

		echo $firstname;

	}

	function updateUser() {

		$user_firstname = $_POST['user_save_name'];
		$user_company = $_POST['user_save_company'];
		$user_email = $_POST['user_save_email'];
		$user_status = $_POST['user_save_status'];
		$user_save_password = $_POST['user_save_password'];
		$secure_password = password_hash($user_save_password, PASSWORD_DEFAULT);


		if ( $this->db->query("UPDATE  users  SET email ='$user_email', firstname='$user_firstname', password='$secure_password', company='$user_company', status='$user_status' WHERE email = '$user_email'") ) {
			echo $user_firstname . " has been updated";
		} else {
			echo "There was an error adding the user.";
		}

	}

	public function addUser()
	{

		$user_firstname = $_POST['userName'];
		$user_company = $_POST['userCompany'];
		$user_email = $_POST['userEmail'];
		$user_pass = $_POST['userPassword'];
		$userLevel = $_POST['userLevel'];
		$user_username = str_replace(" ", "_", $user_firstname);
		$password = password_hash($user_pass, PASSWORD_DEFAULT);
		$profilePic = "default.jpg";

		if ( $this->db->query("INSERT INTO  users (username, password, email, firstname, company, profilePic, status) VALUES ('$user_username', '$password', '$user_email', '$user_firstname', '$user_company', '$profilePic', '$userLevel')") ) {
			$session_data = $this->session->userdata('logged_in');
			$this->template->load_template("users",$session_data);
		}


	}

}
