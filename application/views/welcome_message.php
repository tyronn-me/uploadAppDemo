<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="loginBG"></div>


<div id="login_wrap">
	<h1>Banner Preview</h1>
	<p>Sign in and manage your creatives</p>
	<?php if ( isset($error) ) { ?>
		<p class="bg-danger"><?php echo $error; ?></p>
	<?php } ?>
	<form action='<?php echo site_url('VerifyLogin');?>' method='post' name='process'>       
		<input class="inputs" type='text' name='email' id='email' placeholder="Email" size='25' /><br />
		<input class="inputs" type='password' name='password' id='password' placeholder="Password" size='25' /><br />                            
		<input class="button" type='Submit' value='Sign In Now' />            
	</form>
</div><!-- wrap -->