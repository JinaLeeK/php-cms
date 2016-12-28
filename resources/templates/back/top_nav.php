<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">Baby Blog</a>
		<a class="navbar-brand" href="../index.php">Home Site</a>
</div>
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
	<!-- <li><a href="../index.php">HOME SITE</a></li> -->
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?><b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="../posts.php?add_post"><i class="fa fa-fw fa-pencil"></i> New Post</a></li>
			<li><a href="../posts.php?mypost"><i class="fa fa-fw fa-bookmark"></i> My posts</a></li>
			<li><a href="../index.php?change_password"><i class="fa fa-fw fa-exchange"></i> Change Password</a></li>
			<li class="divider"></li>
		  <li><a href="../index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
		</ul>
	</li>

</ul>
