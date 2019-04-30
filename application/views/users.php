<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="wrapper logged-in" id="user-wrapper">

	<?php
		if ( $this->uri->segment(2) == "user" && $this->uri->segment(1) == "Users" )  {
		$query = $this->db->query("SELECT * FROM users WHERE id = " . htmlspecialchars($_GET["userid"]));
		$result = $query->row();
	?>

		<nav class="navbar navbar-light bg-light">
	    <a class="navbar-brand">User Management <span class="badge badge-primary">New</span> <i class="fas fa-angle-double-right"></i> User <i class="fas fa-angle-double-right"></i> <?php echo $result->firstname; ?></a>
	    <form class="form-inline">
	      <p>Don't see what you're looking for? Email <a href="mailto:tyron@thebannermen.com">the admin</a></p>
	    </form>
	  </nav>

		<div class="container-fluid">
			<div class="row">
				<div class="cols col-md-2" id="profileSideBar">
					<div id="profilePicture" style="background: url(<?php echo site_url('uploads/profile_pictures/' . $result->profilePic); ?>) center center no-repeat;"></div>
					<h3><?php echo $result->firstname; ?></h3>
					<p><?php echo $result->company; ?></p>

					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">User Info</a>
		        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Update User</a>
		      </div>

				</div><!-- col -->
				<div class="cols col-md">
			    <div class="tab-content" id="v-pills-tabContent">
			      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							<div class="row">
								<div class="col-md-5">
								<h2>Uploaded Projects</h2>
								<ul class="list-group">
									<?php
										$queryWork = $this->db->query('SELECT * FROM creatives WHERE uploadedBy = "' . $result->email . '" ORDER BY dateUploaded ASC LIMIT 6');
										foreach($queryWork->result_array() as $pro) {
								 	?>
										<li class="list-group-item"><?php echo $pro['size']; ?> - <?php echo $pro['project']; ?><br/><strong><?php echo $pro['dateUploaded']; ?></strong></li>
									<?php } ?>
								</ul>
								</div>
								<div class="col-md">
									<h2>Contact Information</h2>
										<p><?php echo $result->firstname; ?><br/>
										<?php echo $result->email; ?></p>
									</ul>
								</div>
							</div>
						</div>
			      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
							<h2>Update User Information</h2>
							<form id="userForm" action="<?php //echo site_url("/Users/addUser"); ?>" method="post">

								<div class="input-group input-group-sm">
								  <div class="input-group-prepend">
								    <span class="input-group-text">First name</span>
								  </div>
								  <input type="text" aria-label="Firstname" name="userName" id="userName" class="form-control" value="<?php echo $result->firstname; ?>">
								</div>

								<div class="input-group input-group-sm">
								  <div class="input-group-prepend">
								    <span class="input-group-text">Email</span>
								  </div>
								  <input type="text" aria-label="Firstname" name="userEmail" id="userEmail" class="form-control" value="<?php echo $result->email; ?>">
								</div>


								<div class="input-group input-group-sm">
								  <div class="input-group-prepend">
								    <span class="input-group-text">Company</span>
								  </div>
								  <input type="text" aria-label="Firstname" name="userCompany" id="userCompany" class="form-control" value="<?php echo $result->company; ?>">
								</div>

								<button id="userSubmit" type="submit" class="btn btn-dark">Update User</button>
							</form>
						</div>
			    </div>
			  </div><!-- col
			</div><!-- row -->
		</div><!-- container -->

	<?php
		} else {
		$query = $this->db->query("SELECT * FROM users ORDER BY id ASC");
	?>

	<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand">User Management <span class="badge badge-primary">New</span></a>
    <form class="form-inline">
      <p>Don't see what you're looking for? Email <a href="mailto:tyron@thebannermen.com">the admin</a></p>
    </form>
  </nav>

	<div class="container-fluid">
		<div class="row">
		<div class="cols col-md-3">
			<p>User Nav</p>
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Add User/Client</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">All Users <span class="badge badge-dark"><?php echo $query->num_rows(); ?></span></a>
      </div>
    </div>
		<div class="cols col-md">
	    <div class="tab-content" id="v-pills-tabContent">
	      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
					<h2>Add User</h2>
					<form id="userForm" action="<?php echo site_url("/Users/addUser"); ?>" method="post">

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">First name</span>
						  </div>
						  <input type="text" aria-label="Firstname" name="userName" id="userName" class="form-control">
						</div>

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">Email</span>
						  </div>
						  <input type="text" aria-label="Firstname" name="userEmail" id="userEmail" class="form-control">
						</div>

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">Password</span>
						  </div>
						  <input type="password" aria-label="Firstname" name="userPassword" id="userPassword" class="form-control">
						</div>

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">Password Confirm</span>
						  </div>
						  <input type="password" aria-label="Firstname" name="userPasswordConfirm" id="userPasswordConfirm" class="form-control">
						</div>

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">Company</span>
						  </div>
						  <input type="text" aria-label="Firstname" name="userCompany" id="userCompany" class="form-control">
						</div>

						<div class="input-group input-group-sm">
						  <div class="input-group-prepend">
						    <span class="input-group-text">User Level</span>
						  </div>
							<select class="form-control form-control-sm" id="userLevel" name="userLevel">
								<option value="user">User</option>
								<option value="admin">Admin</option>
							</select>
						</div>


						<button id="userSubmit" type="submit" class="btn btn-dark">Add User</button>
					</form>
				</div>
	      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
					<h2>All Users</h2>
					<table class="table table-light table-borderless table-striped">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">Name</th>
					      <th scope="col">Company</th>
					      <th scope="col">Email</th>
								<th scope="col">Username</th>
								<?php if ( $userstatus == "super admin" || $userstatus == "admin" ) { ?>
									<th scope="col">Action</th>
								<?php } ?>
					    </tr>
					  </thead>
					  <tbody>
							<?php foreach ($query->result_array() as $row) { ?>
									<tr>
										<th scope="row"><?php echo $row['id']; ?></th>
										<td><?php echo $row['firstname']; ?></td>
										<td><?php echo $row['company']; ?></td>
										<td class="email_td"><?php echo $row['email']; ?></td>
										<td><?php echo $row['username']; ?></td>
										<?php if ( $userstatus == "super admin" || $userstatus == "admin" ) { ?>
											<td>
												<a href="" data-userid="<?php echo $row['id']; ?>"><i class="far fa-trash-alt"></i></a>
												<a href="<?php echo site_url("Users/user?userid=" . $row['id']); ?>"><i class="fas fa-user-cog"></i></a>
											</td>
										<?php }?>
									</tr>
							<?php } ?>
					  </tbody>
					</table>
				</div>
	    </div>
	  </div>
		</div><!-- row -->
	</div><!-- container -->

	<?php } ?>

	<div class="toast" data-delay="2000" id="userToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px;">
	  <div class="toast-header">
	    <strong class="mr-auto">BP</strong>
	    <small>Now</small>
	    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="toast-body">
	    Please fill in all fields.
	  </div>
	</div>

</div><!-- user wrapper -->
