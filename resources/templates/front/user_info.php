<div class="panel-group">
	<div class="login-info">Logged in as
		<span class="text-primary"><a href="javascript:;" data-toggle="collapse" data-target="#user_dropdown">
			<strong><?php echo $_SESSION['username']; ?>&nbsp;<b class="caret"></b></strong>
		</a></span></div>
	 <ul id="user_dropdown" class="collapse categories_list">
		 <li><a href="posts.php?add_post"><span class="glyphicon glyphicon-pencil"></span>&nbsp;New Post</a></li>
		 <li><a href="posts.php?mypost"><span class="glyphicon glyphicon-th-list"></span>&nbsp;My Posts</a></li>
		 <li><a href="index.php?change_password"><span class="glyphicon glyphicon-transfer"></span>&nbsp;Change Password</a></li>
	 </ul>
	 <div class="entry-meta">
		 <?php if(isset($_SESSION['user_role'])) { ?>
		 <span><span class="glyphicon glyphicon-cog"></span><a href="admin/index.php"> Admin</a></span>
		 <?php } ?>
		 <span><span class="glyphicon glyphicon-log-out"></span><a href="index.php?logout"> Logout</a></span>
	 </div>
</div>
