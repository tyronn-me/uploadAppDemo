<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$workQuery = $this->db->query("SELECT * FROM creatives ORDER BY dateUploaded DESC LIMIT 10");
?>

<div class="wrapper logged-in" id="dashboard-wrapper">
	
	<div class="dashboard-box" id="recent-uploads">
		<h3>Recent Uploads</h3>
		<ul>
			<li id="dashboard_header_row"><span>Name</span><span>Date Uploaded</span></li>
		<?php foreach ($workQuery->result_array() as $row) { ?>
			<li><span><?php echo $row['name']; ?></span><span><?php echo $row['dateUploaded']; ?></span></li>
		<?php } ?>
		</ul>
	</div><!-- recent uploads -->
	
	<div class="dashboard-box" id="recent-uploads">
		<h3>Recent Logins</h3>
		
	</div><!-- recent uploads -->

	<div class="clear"></div>
</div><!-- wrapper -->