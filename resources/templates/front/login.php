<?php user_login(); ?>
<div class="title">
	<h1>Login</h1>
</div>

<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
				<div class="form-wrap">
				<h4 class="bg-warning"><span class="msg"><?php display_message(); ?></span></h4>
						<form role="form" action="" method="post" id="login-form" autocomplete="off">
								<div class="form-group">
										<label for="username" class="sr-only">username *</label>
										<input type="text" name="username" id="username" class="form-control" placeholder="Username *">
								</div>

								 <div class="form-group">
										<label for="password" class="sr-only">Password *</label>
										<input type="password" name="password" id="key" class="form-control" placeholder="Password *">
								</div>

								<input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-block" value="Login">
						</form>

				</div>
				<br>
				<span><a href="index.php?register">Register</a></span>
				<span class="pull-right">Forgot password? Click <a href="index.php?password">hear.</a></span>
				<br>
		</div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
