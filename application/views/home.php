<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<?php if ( $userstatus != "user") { ?>
	<div class="wrapper">
	<div class="container-fluid">

		<nav class="navbar navbar-light bg-light">
	    <a class="navbar-brand">Dashboard <i class="fas fa-angle-double-right"></i> <?php echo $firstname; ?></a>
	    <form class="form-inline">
	      <p>Don't see what you're looking for? Email <a href="mailto:tyron@thebannermen.com">the admin</a></p>
	    </form>
	  </nav>

		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong>Uploads &amp; Previews</strong> The upload and preview pages will be getting tweaked and some features may stop working while this is in progress.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>

	  <div class="row">
	    <div class="cols col-md-4 main-col">
	      <h2>Guidelines <span class="badge badge-danger">Please Read</span></h2>
				<p class="lead">Before you begin,  <a href="<?php echo site_url("Faq"); ?>">please read the FAQ page</a> and become familiar with the uploading process.</p>
	    </div>
	    <div class="cols col-md">
				<h2>Creative Upload</h2>
				<p>Please fill out all fields and check your files before uploading.</p>
				<?php if ( isset($confirm) ) { ?>
					<div class="alert alert-success" role="alert">
						<?php echo $confirm; ?>
					</div>
				<?php } ?>
						<form method="post" enctype="multipart/form-data" action="<?php echo site_url("Home/uploadCreative"); ?>" id="bannerPreviewUploadForm">

							<input type="hidden" name="uploadedBy" id="uploadedBy" value="<?php echo $userEmail; ?>"/>
							<input type="hidden" name="uploadedDate" id="uploadedDate" value="<?php echo date("F j, Y, g:i a"); ?>"/>

							<div class="input-group input-group-sm">
							  <div class="input-group-prepend">
							    <span class="input-group-text">Client</span>
							  </div>
								<select class="form-control form-control-sm" id="clientName" name="clientName">
									<option value="">Select Client</option>
									<?php
										$queryClient = $this->db->query('SELECT DISTINCT company FROM users ORDER BY company ASC');
										foreach($queryClient->result_array() as $clientRow) {
									?>
									<option value="<?php echo $clientRow['company']; ?>"><?php echo $clientRow['company']; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="input-group input-group-sm">
							  <div class="input-group-prepend">
							    <span class="input-group-text">Campaign Name</span>
							  </div>
							  <input type="text" aria-label="First name" name="campainName" id="campainName" class="form-control">
							</div>

							<div class="input-group mb-3">
							  <div class="custom-file">
							    <input type="file" class="custom-file-input" name="inputGroupFile01" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
							    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							  </div>
							</div>

							<button type="submit" class="btn btn-dark">Submit</button>
						</form>
	    </div>
	  </div>
		<div class="row">
	    <div class="cols col-md">
				<h2>Recent Uploads</h2>
				<table class="table">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Name</th>
			      <th scope="col">Size</th>
			      <th scope="col">Uploader</th>
			      <th scope="col">Upload Date</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
					$queryWork = $this->db->query('SELECT * FROM creatives ORDER BY dateUploaded DESC LIMIT 6');
					foreach($queryWork->result_array() as $pro) {
				?>
				<tr>
		      <th scope="row"><?php echo $pro['name']; ?></th>
		      <td><?php echo $pro['size']; ?></td>
		      <td><?php echo $pro['uploadedBy']; ?></td>
		      <td><?php echo $pro['dateUploaded']; ?></td>
		    </tr>
				<?php } ?>
				</tbody>
			</table>
			</div><!-- col -->
		</div><!-- row -->
	</div><!-- container -->
	</div><!-- wrapper -->
	<?php } else { ?>

		<div class="container" id="clientContainer">

			<div class="alert alert-secondary alert-dismissible fade show" role="alert">
			  Banner Preview is still in alpha. You may experience some bugs as we work hard to create a great service for you.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>

			<nav class="navbar navbar-light bg-light">
		    <a class="navbar-brand"><div id="clientProfilePic" style="background: url(<?php echo site_url('uploads/profile_pictures/' . $profilePic); ?>) center center no-repeat;"></div> Your Dashboard <span class="badge badge-primary">New</span></a>
				<form class="form-inline">
		     	<a class="btn btn-dark btn-sm" href="<?php echo site_url("Home/logout"); ?>" role="button">logout</a>
		    </form>
		  </nav>

			<div class="row">
				<div class="col-md-3">
					<h3>Weclome <?php echo $firstname; ?></h3>
					<p>View and manage your creatives.</p>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">My Creatives</a>
		      </div>
		    </div>
				<div class="col-md">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-profile-tab">
							<table class="table table-light table-borderless">
							  <thead class="thead-dark">
							    <tr>
							      <th scope="col">Campaign Name</th>
							      <th scope="col">Size</th>
							      <th scope="col">Version</th>
							      <th scope="col">Date</th>
										<th scope="col">Action</th>
							    </tr>
							  </thead>
								  <tbody>
									<?php
										$mysession_data = $this->session->userdata('logged_in');
										$mycompany = $mysession_data['company'];
										$queryWork = $this->db->query("SELECT * FROM creatives WHERE client = '$mycompany'  ORDER BY dateUploaded DESC");
										foreach($queryWork->result_array() as $pro) {
											preg_match("/(\d+).*?(\d+)/",$pro['size'],$creativeSizeArr);
									?>
										<tr>
											<th scope="row"><?php echo $pro['project']; ?></th>
											<td><?php echo $pro['size']; ?></td>
											<td><?php echo $pro['version']; ?></td>
											<td><?php echo $pro['dateUploaded']; ?></td>
											<td>
												<button id="clientViewCreative" type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#exampleModalScrollable" data-unitlink="<?php echo urldecode($pro['link']); ?>" data-unitwidth="<?php echo $creativeSizeArr[1]; ?>" data-unitheight="<?php echo $creativeSizeArr[2]; ?>" data-unitname="<?php echo $pro['name']; ?> - <?php echo $pro['size']; ?> - <?php echo $pro['version']; ?>">view creative</button>
												<button id="clientCreateNote" type="button" class="btn btn-light btn-sm disabled" data-toggle="modal" data-target="#feedbackModal" disabled>Add Feedback <span class="badge badge-secondary">coming soon</span></button>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div><!--- row -->
		</div><!-- container -->

	<!-- Modal -->
	<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
	    <div class="modal-content">

	      <div class="modal-body">
	        <iframe src="" width="300" height="250"></iframe>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- feedback modal -->
	<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creative Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="<?php echo site_url("Home/addFeedback"); ?>">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Your notes:</label>
						<input type="hidden" id="creativeID" name="creativeID" value=""/>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send feedback</button>
      </div>
    </div>
  </div>
</div>

	<?php } ?>
