<div id="header">
	<div id="logo"><h1><a href="index.php">
		<?php
			$query = query("SELECT * FROM messages WHERE message_title='title'");
			confirmQuery($query);
			$row = fetch_array($query);
			echo $row['message_content'];
		?>
			</a></h1></div>
	<div id="menu">
		<ul id="navigation" >
			<?php
			if(!isset($_GET['cat_id'])) {
			?>
				<li><a href="index.php" class="active">Home</a></li>
			<?php } else { ?>
				<li><a href="index.php">Home</a></li>
			<?php } ?>
			<?php get_cat_in_top_nav(); ?>
      <?php if(!isset($_SESSION['username'])) { ?>
				<li><a href="index.php?login" style="border:none;">Login</a> </li>
			<?php } else {?>
				<li><a href="index.php?logout" style="border:none;">Logout</a> </li>
			<?php } ?>
		</ul>
	</div>
</div>
