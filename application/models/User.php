<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Model {

    function login($email, $password) {

	     $query = $this->db->query("SELECT id, firstname, profilePic, email, password, company, status FROM users WHERE email = '$email' LIMIT 1");
		 $row = $query->row();
		 $hash = $row->password;

		if ( password_verify($password, $hash) ) {
		     return $query->result();
		} else {
		    return false;
		}

    }// function

}// class
?>
