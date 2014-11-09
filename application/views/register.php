<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<form method="post" action="<?php echo base_url(); ?>users/register">
	<div class="form-group">
		<label>First Name*</label>
		<input type="text" class="form-control" name ="first_name" placeholder="Enter your first name"/ >
	</div>
	<div class="form-group">
		<label>Last Name*</label>
		<input type="text" class="form-control" name ="last_name" placeholder="Enter your last name"/ >
	</div>
	<div class="form-group">
		<label>Email Address*</label>
		<input type="text" class="form-control" name ="email" placeholder="Enter Your Email Address"/ >
	</div>
	<div class="form-group">
		<label>Choose Username*</label>
		<input type="text" class="form-control" name ="username" placeholder="Enter Your Username"/ >
	</div>
	<div class="form-group">
		<label>Choose Password*</label>
		<input type="password" class="form-control" name ="password" placeholder="Enter Your Password"/ >
	</div>
	<div class="form-group">
		<label>Confirm Password*</label>
		<input type="password" class="form-control" name ="password2" placeholder="Enter Your Password Again"/ >
	</div>
	<button name="submit" type="submit" class="btn btn-primary">Register</button>
</form>