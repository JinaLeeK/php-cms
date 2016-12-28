<?php user_register(); ?>

<div class="title">
	<h1>Register</h1>
</div>

<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
				<div class="form-wrap">
					<h4 class="bg-warning"><span class="msg"><?php display_message(); ?></span></h4>
							<form role="form" action="" method="post" id="register-form" autocomplete="off">
									<div class="form-group">
											<label for="username" class="sr-only">username *</label>
											<input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username *">
									</div>
									 <div class="form-group">
											<label for="email" class="sr-only">Email *</label>
											<input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com *">
									</div>
									 <div class="form-group">
											<label for="password" class="sr-only">Password *</label>
											<input type="password" name="password" id="key" class="form-control" placeholder="Password *">
									</div>
									 <div class="form-group">
											<label for="password" class="sr-only">Confirm Password *</label>
											<input type="password" name="password2" class="form-control" placeholder="Confirm password *">
									</div>
									<input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">

							</form>
							<br>
							<span>Already have a username? <a href="index.php?login">here</a>.</span>
				<br>
		</div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
