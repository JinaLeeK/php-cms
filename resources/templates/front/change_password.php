<?php get_password_in_user(); ?>

<div class="title">
	<h1>Change password</h1>
</div>

<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
				<div class="form-wrap">
				<h4 class="bg-warning"><span class="msg"><?php display_message(); ?></span></h4>
						<form role="form" action="" method="post" id="login-form" autocomplete="off">
							<div class='form-group'>
									<input type='password' name='oldpassword' class='form-control' placeholder='Current password *' required>
							</div>
							<div class='form-group'>
									<input type='password' name='newpassword' class='form-control' placeholder='New Password *' required>
							</div>
							<div class='form-group'>
									<input type='password' name='repeatnewpassword' class='form-control' placeholder='Repeat new password *' required>
							</div>
							<button class='btn btn-primary btn-block' type='submit' name="change_password">Change Password</button>

						</form>

				</div>
		</div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
