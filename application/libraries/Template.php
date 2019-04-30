<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Template {
	
	protected $CI;
	
	public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
    }
	
	public function load_template($view_file_name,$session_data = null) {
		
		if ( $session_data != null ) {
      
			$userinfo = $this->CI->db->query('SELECT * FROM users WHERE email = "' . $session_data['email'] . '"');
	        foreach($userinfo->result_array() as $info) {
	            $username = $info['username'];
	            $firstname = $info['firstname'];
	            $userEmail = $info['email'];
	            $profilePic = $info['profilePic'];
	            $userstatus = $info['status'];
	        }
	
		    
		    $data['username'] = $username;
		    $data['firstname'] = $firstname;
		    $data['userEmail'] = $userEmail;
		    $data['profilePic'] = $profilePic;
		    $data['userstatus'] = $userstatus;
		    
		    $this->CI->load->view("parts/header",$data);
			$this->CI->load->view($view_file_name, $data);
			$this->CI-> load->view("parts/footer");
	    
	    } else {
			
			$this->CI->load->view("parts/header");
			$this->CI->load->view($view_file_name);
			$this->CI-> load->view("parts/footer");
		
		}
	
	}

}