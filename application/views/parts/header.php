<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Banner Preview - Brought To You By The Bannermen Ltd</title>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Muli:300,400,900');
		@import url('https://fonts.googleapis.com/css?family=Montserrat:300,900');
	</style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/style.css" type="text/css"/>
</head>
	<body ng-app="bannerPreview">
		<div id="notificationCenter"></div>
	<?php if ( $this->session->userdata('logged_in') && $this->uri->segment(2) != "creatives" ) {  ?>
		<?php if ( $userstatus != "user") { ?>
		<div id="header">
			<div id="innerHeader">
				<div id="logo">
					<h1>BP</h1>
				</div><!-- logo -->
				<div id="menu">
						<a class="icons" href="<?php echo site_url(); ?>Home" id="profile_picture"><img src="<?php echo site_url("uploads/profile_pictures/" . $profilePic); ?>"/><div id="BPloader"></div></a>
						<a class="icons <?php if($this->uri->segment(1)=="Home"){ echo 'active'; } ?>" href="<?php echo site_url(); ?>Home" id="menu-upload"><i class="fas fa-tachometer-alt"></i></a>
						<a class="icons <?php if($this->uri->segment(1)=="Preview"){ echo 'active'; } ?>" href="<?php echo site_url('Preview'); ?>" id="menu-preview"><i class="fas fa-ad"></i></a>
						<a class="icons <?php if($this->uri->segment(1)=="Users"){ echo 'active'; } ?>" href="<?php echo site_url('Users'); ?>" id="menu-user"><i class="fas fa-users-cog"></i></a>

						<?php if ( $userstatus == "super admin" ) { ?>
							<a class="icons <?php if($this->uri->segment(1)=="Notifications"){ echo 'active'; } ?>" href="<?php echo site_url('Notifications'); ?>" id="menu-user"><i class="fas fa-comment-dots"></i></a>
						<?php } ?>

						<a class="icons <?php if($this->uri->segment(1)=="Faq"){ echo 'active'; } ?>" href="<?php echo site_url('Faq'); ?>" id="menu-user"><i class="far fa-question-circle"></i></a>
					<a class="icons" href="<?php echo site_url('Home/logout'); ?>" id="menu-logout"><i class="fas fa-sign-out-alt"></i></a>
				</div><!-- menu -->
				<div class="clear"></div>
			</div><!-- inner -->
			<div id="notificationCenterMenu"></div>
			<div id="buildVersion">
				<p>0.4</p>
			</div>
		</div><!-- header -->
		<?php } ?>
	<?php } ?>
