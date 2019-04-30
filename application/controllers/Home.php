<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
					$this->template->load_template("home",$session_data);
		} else {
				redirect("", 'refresh');
			}
	}

	function logout() {

        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect("", 'refresh');

    }

    function getNotifications() {

	    $query = $this->db->query("SELECT * FROM notification");
	    $notificationArray = array();

			foreach ($query->result() as $row)
			{
					$notification = array("Notification" => $row->notification_text, "Status" => $row->status);
					$notificationArray[] = $notification;
			}

			echo json_encode($notificationArray);

    }

		function checkCampaignExist() {

			$campaign = $_POST['campaign'];

			$query = $this->db->query("SELECT project FROM creatives WHERE project LIKE '$campaign'");

			if ( $query->num_rows() > 0 ) {
				echo "Campain Exisits";
			} else {
				echo "Fine";
			}

		}

		function uploadCreative() {
			// Delcare Variables
			$return_arr = null;
			// Get file info
			$filename = $_FILES['inputGroupFile01']['name'];
	    $filesize = $_FILES['inputGroupFile01']['size'];
			$fileTempName = $_FILES['inputGroupFile01']['tmp_name'];
			$filenameClean = str_replace(".zip", "", $filename);
			// get name and campaign info
			if ( isset($_POST['clientName']) && $_POST['clientName'] != "" && isset($_POST['campainName']) && $_POST['campainName'] != "" && isset($_POST['uploadedBy']) && $_POST['uploadedBy'] != "" && isset($_POST['uploadedDate']) && $_POST['uploadedDate'] != "" ) {
				$clientName = strip_tags(trim($_POST['clientName']));
				$campainName = strip_tags(trim($_POST['campainName']));
				$uploadedBy = $_POST['uploadedBy'];
				$uploadedDate = $_POST['uploadedDate'];

				$clientNameDB = strip_tags($_POST['clientName']);
				$campainNameDB = strip_tags($_POST['campainName']);

				$locationFolder = FCPATH . "uploads/creatives/" . preg_replace("/[^a-zA-Z]+/", "", $clientName) . "/" . preg_replace("/[^a-zA-Z]+/", "", $campainName);
				$location = $locationFolder . "/" . str_replace("zip", "", preg_replace("/[^a-zA-Z]+/", "", $filename));

				if (!file_exists($locationFolder)) {
					mkdir($locationFolder, 0775, true);
				}
					if(move_uploaded_file($fileTempName,$location)){

						$path = pathinfo(realpath($location), PATHINFO_DIRNAME);

						//Unzip
						$zip = new ZipArchive;
						$res = $zip->open($location);

						if ($res === TRUE) {
							$zip->extractTo($locationFolder);
							$zip->close();
							unlink($location);
							// Delete __MACOSX directory that osx creates in zip
							$osxDir = $locationFolder . "/__MACOSX";
							if ( file_exists($osxDir) ||  is_dir($osxDir) ) {
								$osxDirit = new RecursiveDirectoryIterator($osxDir, RecursiveDirectoryIterator::SKIP_DOTS);
								$osxfiles = new RecursiveIteratorIterator($osxDirit, RecursiveIteratorIterator::CHILD_FIRST);

								foreach($osxfiles as $osxfile) {
								    if ($osxfile->isDir()){
								        rmdir($osxfile->getRealPath());
								    } else {
								        unlink($osxfile->getRealPath());
								    }
								}

								rmdir($osxDir);
							}
							// Handle info creation
							if ($handle = opendir($locationFolder)) {
						    	while ($entry = readdir($handle)) {
							    	if ( $entry != "." && $entry != ".." && $entry != "__MACOSX" && $entry != $filename) {

								    	$creativeLink = urlencode(site_url("uploads/creatives/" . preg_replace("/[^a-zA-Z]+/", "", $clientName) . "/" . preg_replace("/[^a-zA-Z]+/", "", $campainName) . "/" . $entry));
											$creativePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/creatives/" . preg_replace("/[^a-zA-Z]+/", "", $clientName) . "/" . preg_replace("/[^a-zA-Z]+/", "", $campainName) . "/" . $entry;
								    	$creativeLink = $this->db->escape($creativeLink);

						            	$creativeSizeArr = array();
						            	preg_match("/(\d+).*?(\d+)/",$entry,$creativeSizeArr);
						            	$creativeSize = $creativeSizeArr[1] . "x" . $creativeSizeArr[2];
													// version
													$vPos = strpos($entry, "v");
													$entryLength = strlen($entry);
													$vPos = $entryLength - $vPos;
													$entryVersion = substr($entry, -$vPos);
													$queryCheck = $this->db->query("SELECT * FROM creatives WHERE size = '$creativeSize' AND client = '$clientNameDB' AND version = '$entryVersion' AND project = '$campainNameDB'");

						            	$linkArr[] = array("URL" => site_url("uploads/creatives/" . preg_replace("/[^a-zA-Z]+/", "", $clientName) . "/" . preg_replace("/[^a-zA-Z]+/", "", $campainName) . "/" . $entry));


													if ( $queryCheck->num_rows() == 0 ) {
						            		$this->db->query("INSERT INTO creatives (name, link, uploadPath, size, client, version, project, uploadedBy, dateUploaded, isApproved, clientApproved) VALUES ('$filenameClean', $creativeLink, '$creativePath', '$creativeSize', '$clientNameDB', '$entryVersion', '$campainNameDB', '$uploadedBy', '$uploadedDate','Not Approved','Not Approved')");
													}
						            }
								}
								closedir($handle);
							}
						}

						$session_data = $this->session->userdata('logged_in');
						$data['firstname'] = $session_data['firstname'];
						$data['userEmail'] = $session_data['email'];
						$data['userstatus'] = $session_data['status'];
						$data['profilePic'] = $session_data['profilePic'];
						$data['company'] = $session_data['company'];
						$data['confirm'] = 'You have successfully uploaded creatives for ' . $clientName . '. You may view it <a href="' . site_url("Preview") . '">view it here</a>.';
						$this->load->view('parts/header', $data);
						$this->load->view('home', $data);
						$this->load->view('parts/footer',$data);

					}


			}

		}

}
