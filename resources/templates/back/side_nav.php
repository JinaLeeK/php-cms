<?php
	$_dashboard = '';
  if($_SERVER['REQUEST_URI'] == ('/kids01/admin/index.php')) {
	 	$_dashboard = 'active';
	} else {
		$_dashboard = '';
	}
	$_users = toggle_class('users');
	$_categories = toggle_class('categories');
	if(isset($_GET['edit_category'])) {
		$_categories = 'active';
	}
	$_comments = toggle_class('comments');
	$_slides = toggle_class('slides');
	$_posts = toggle_class('posts');
	?>

<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav">
				<li class="<?php echo $_dashboard; ?>">
						<a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
				</li>
				<li class = "<?php echo $_posts; ?>">
						<a href="index.php?posts"><i class="fa fa-fw fa-bar-chart-o"></i> Posts</a>
				</li>
				<li class = "<?php echo $_categories; ?>">
						<a href="index.php?categories"><i class="fa fa-fw fa-bar-chart-o"></i> Categories</a>
				</li>

				<li class="<?php echo $_comments; ?>">
						<a href="index.php?comments"><i class="fa fa-fw fa-table"></i> Comments</a>
				</li>
				<li class="<?php echo $_users; ?>">
						<a href="index.php?users"><i class="fa fa-fw fa-table"></i> Users</a>
				</li>

				<li class="<?php echo $_slides; ?>">
						<a href="index.php?slides"><i class="fa fa-fw fa-wrench"></i> Slides</a>
				</li>

		</ul>
</div>
