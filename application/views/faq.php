<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="wrapper">

  <nav class="navbar navbar-light bg-light">
    <a class="navbar-brand">Frequenly Asked Questions <span class="badge badge-primary">New</span></a>
    <form class="form-inline">
      <p>Don't see what you're looking for? Email <a href="mailto:tyron@thebannermen.com">the admin</a></p>
    </form>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="cols col-md-3">
        <p>How can I help <?php echo $firstname; ?>?</p>
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Uploading</a>
          <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Adding Users</a>
        </div>
      </div>
      <div class="cols col-md">
  	    <div class="tab-content" id="v-pills-tabContent">
  	      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
  					<h2>How do I upload Files?</h2>
            <p>Uploading files to Banner Preview is simple and fast. Just follow the steps below</p>
            <p><strong>File Organization</strong></p>
            <p>Files that are uploaded to <strong>BP</strong> need to have the correct naming convention to work properly within the system.
            The easiest way to remember this is to organize them as if you were delivering them to a client. Below is a video of how to prepare for the upload process.<p>

            <p>Note that the creatives naming convetion ( 300x600_v1 ). This naming convention is very important so please adhere to it. The names of the creative folders can only include size and version as shown.</p>

            <video id="homeVideo" controls>
    				  <source src="<?php echo site_url("images/videos/tutorial.mp4"); ?>" type="video/mp4">
    				  <source src="<?php echo site_url("images/videos/tutorial.webm"); ?>" type="video/webm">
    				Your browser does not support the video tag.
    				</video>

  				</div>
  	      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
  					<h2>How do I add users?</h2>
            <p>Adding people/clients are easy! Just visit <a href="<?php echo site_url("Users"); ?>">the user page</a> and fill out the form!</p>
  				</div>
  	    </div>
  	  </div>
    </div><!-- col -->
  </div><!-- row --->

</div><!-- wrapper -->
