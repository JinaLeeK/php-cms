<?php get_password_in_user(); ?>

<div class="title">
	<h1>Forgot password</h1>
</div>

<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
				<div class="form-wrap">
				<h4 class="bg-warning"><span class="msg"><?php display_message(); ?></span></h4>
						<form role="form" action="" method="post" id="login-form" autocomplete="off">
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon'><span class="glyphicon glyphicon-user"></span></span>
									<input type='text' name='username' class='form-control' placeholder='Username' required>
								</div>
							</div>
							<div class='form-group'>
								<div class='input-group'>
									<span class='input-group-addon'>@</span>
									<input type='email' name='email' class='form-control' placeholder='Email' required>
								</div>
							</div>
							<button class='btn btn-primary btn-sm btn-block' type='submit' name="get_password">Forgot Password</button>
							<a href="index.php?login" class="btn btn-success btn-sm btn-block" style='color:#fff;'>Login</a>
						</form>

				</div>
		</div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
