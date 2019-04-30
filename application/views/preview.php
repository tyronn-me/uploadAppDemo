<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
	if ( $this->uri->segment(2) === "creatives" )  {
	$urlParArr = explode(",", htmlspecialchars($_GET["id"]));
	$urlParArrEx = array();
	$campaignArr = array();
	foreach($urlParArr as $urlParID) {
		$urlParArrEx[] = base64_decode($urlParID);
	}
	$urlPar = implode(",", $urlParArrEx);
	$query = $this->db->query("SELECT * FROM creatives WHERE id IN ($urlPar)");
?>
<?php foreach($query->result_array() as $campaign) {
		if ( !in_array(array($campaign['project'],$campaign['client']), $campaignArr) ) {
			$campaignArr[] = array($campaign['project'], $campaign['client']);
		}
	} ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Banner Preview - <span><?php foreach($campaignArr as $campaignName ) { echo '<span class="badge badge-danger">' . str_replace("_", " ", $campaignName[1]) . ' - ' . $campaignName[0] . '</span>'; } ?></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
			<li class="nav-item dropdown">
		    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Choose Unit Size</a>
		    <div class="dropdown-menu">
					<?php
						foreach ($query->result_array() as $row)
							{
										$creativeSizeArr = array();
										preg_match("/(\d+).*?(\d+)/",$row['size'],$creativeSizeArr);

										$urlFetch = urldecode($row['link']);
										$uri_segments = explode('/', $urlFetch);

										// $version = explode('v', $uri_segments[7]);
										$version = substr($uri_segments[7], strpos($uri_segments[7], "v") + 1);
										echo '<a class="creativePreivewFrameLink" href="#" data-frameurl="' . $urlFetch . '" data-unitversion="' . $version . '" data-framewidth="' . $creativeSizeArr[1] .'" data-frameheight="' . $creativeSizeArr[2] .'">' . $creativeSizeArr[1] .'x' . $creativeSizeArr[2] . " - v" . $version . "</a>";
							}
					?>
		      <div class="dropdown-divider"></div>
		      <a class="mailto:tbmdcm@gmail.com" href="#">Email Support</a>
		    </div>
		  </li>
    </ul>
  </div>
</nav>

<div id="creativePreview_content"></div><!-- content -->

<?php
/*
Main Preview Page below
*/
?>

<?php }
	if ( $this->uri->segment(2) == "" && $this->uri->segment(1) == "Preview" )  {

?>

<div id="preview_sidebar">
	<h2><i class="fas fa-th-list"></i> Campaigns</h2>
	<div id="preview_sidebar_links">
	<?php
	$campaignQuery = $this->db->query("SELECT * FROM creatives GROUP BY project");
	if ( $campaignQuery->num_rows() > 0 ) {
		foreach ($campaignQuery->result_array() as $row) {
			$proCount = $this->db->query("SELECT project FROM creatives WHERE project = '" . $row['project'] . "'");
			echo '<div class="campaignListItem" data-procount="' . $proCount->num_rows() . '" data-campaign="' . $row['project'] . '" data-client="' . $row['client'] . '"><h3>' . $row['client'] . '</h3><p>' . $row['project'] . '</p></div>';
		}
	} else {
		echo '<div class="campaignListItem"><p>When you upload creatives, the campaign will be listed here.</p></div>';
	}
 	?>
	</div>
</div><!-- preview sidebar -->

<div id="previewLoader">
	<div id="loadingSpinner" class="spinner-border text-dark" role="status">
	  <span class="sr-only">Loading...</span>
	</div>
</div>

<div id="preview_nav">
	<div id="previewLink"></div>
	<a href="" id="delete_creatives" class="preview_nav_ui disabled">Delete Selected <i class="far fa-trash-alt"></i></a>
	<a href="" id="creative_preview_link" class="preview_nav_ui disabled">Create Preview <i class="fas fa-external-link-alt"></i></a>
</div><!-- nav -->

<div id="preview_content">

	<?php if ( $campaignQuery->num_rows() > 0 ) { ?>
		<div id="previewWelcome">
			<p><i class="fas fa-arrow-circle-left"></i> Select a campaign in the sidebar</p>
		</div><!-- preview welcome -->
	<?php } else { ?>
		<div class="jumbotron jumbotron-fluid bg-dark text-white">
		  <div class="container">
		    <h1 class="display-4">Campaigns &amp; Creatives</h1>
		    <p class="lead">Campaign and the creatives belonging to that campaing will live here. Modify, delete and creative previews of each campaign will be possible on this page.</p>
		  </div>
		</div>
	<?php } ?>

	<div class="container-fluid" id="previewMainContentArea">

		<nav class="navbar navbar-light bg-light">
	    <a class="navbar-brand">Preview</a>
	    <form class="form-inline">
	      <p>Don't see what you're looking for? Email <a href="mailto:tyron@thebannermen.com">the admin</a></p>
	    </form>
	  </nav>

		<div class="row" style="margin-bottom: 20px;">
			<div class="col-md">
				<div id="campaign_dropzone">
					<form method="post" enctype="multipart/form-data" action="<?php echo site_url("Home/uploadCreative"); ?>" class="dropzone" id="campaign_bannerPreviewUploadForm">

						<input type="file" name="file" id="file"/>
						<input type="hidden" name="uploadedBy" id="uploadedBy" value="<?php echo $userEmail; ?>"/>
						<input type="hidden" name="uploadedDate" id="uploadedDate" value="<?php echo date("F j, Y, g:i a"); ?>"/>

						<input type="hidden" class="inputs creativeUpload_input" name="clientName" id="clientName" placeholder="Client / Studio Name*"/>
						<input type="hidden" class="inputs creativeUpload_input" name="campainName" id="campainName" placeholder="Campaign*"/>

					</form>
				</div><!-- campaign_dropzone -->
			</div><!-- cols -->
		</div><!-- upload area -->
		<div class="row">
			<div class="col-md">
			<table class="table table-light table-borderless table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Dimensions</th>
						<th scope="col">Uploaded</th>
						<th scope="col">version</th>
						<th scope="col">Actions / Links</th>
					</tr>
				</thead>
				<tbody id="previewContentArea">
				</tbody>
			</table>
			</div><!-- cols -->
		</div><!-- row -->
	</div><!-- container -->
</div><!-- content -->

<?php } ?>
