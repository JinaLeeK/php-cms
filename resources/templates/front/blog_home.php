<div id="welcome_text">
	<h1>Welcome</h1>
	<p><img src="media/teddy000.jpg" alt="Teddy" width="120" height="113" align="right" class="image_padding" />
		<?php
		$query = query("SELECT * FROM messages WHERE message_title='welcome' LIMIT 1");
		confirmQuery($query);
		$row = fetch_array($query);
		echo $row['message_content'];
		?>
		</p>
</div>
<p class="more"></p>
<div id="post_in_home">
	<div class="row">
		<?php get_cat_in_home(); ?>
</div>
<br class="clear" />
</div>
<br class="clear" />
