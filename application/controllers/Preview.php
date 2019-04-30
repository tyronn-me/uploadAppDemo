<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preview extends CI_Controller {

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
			$this->template->load_template("preview",$session_data);
		} else {
				redirect("", 'refresh');
			}
	}

	public function creatives()
	{
			$this->template->load_template("preview");
	}

	public function creatives_review()
	{
			if ( $this->session->userdata('logged_in') ) {
        		$session_data = $this->session->userdata('logged_in');
				$this->template->load_template("preview", $session_data);
			} else {
				redirect("", 'refresh');
			}
	}

	function approveCreative() {

		$ID = $_POST['id'];
		$status = $_POST['status'];

		if ( $this->db->query("UPDATE creatives SET isApproved='$status' WHERE id='$ID'") ) {
			echo "Your creative has been approved";
		} else {
			echo "An error has occurred. Please contact site admin and try again later";
		}

	}

	function delete_creatives() {

		$urls = $_POST['linkArr'];
		$urlParArr = explode(",", $urls);

		foreach($urlParArr as $urlParID) {

			$fileID = base64_decode($urlParID);
			$query = $this->db->query("SELECT * FROM creatives WHERE id='$fileID'");
			$res = $query->result();  // this returns an object of all results
			$row = $res[0];
			$filePath = $row->uploadPath;

			if ( $this->db->query("DELETE FROM creatives WHERE id = '$fileID'") ) {
				$this->delete_target_files($filePath);
			}

		}

	}

	function delete_target_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            $this->delete_target_files( $file );
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );
    }
	}

	function getPreviewBoxes() {

		$campaignName = $_POST['campaign'];
		$data = null;

		$query = $this->db->query("SELECT * FROM creatives WHERE project = '$campaignName' ORDER BY dateUploaded ASC");

		foreach ($query->result_array() as $row)
		{

			$byEmail = $row['uploadedBy'];
			$createiveUserQuery = $this->db->query("SELECT profilePic FROM users WHERE email = '$byEmail'");
			$ret = $createiveUserQuery->row();
			$data .= '<tr class="createiveBoxes" data-creativeid="'. base64_encode($row['id']) . '">';
			$data .= '<th scope="row">'. $row['size'] . '</th>';
				$data .= '<td>'. $row['dateUploaded'] . '</td>';
				$data .= '<td>'. str_replace("v", "", $row['version']) . '</td>';
				$data .= '<td><a href="'. urldecode($row['link']) . '" target="_blank" data-unitid="'. $row['id'] . '"><i class="fas fa-external-link-alt"></i></a></td>';
			$data .= '</tr>';

		}

		echo $data;

	}

}
