<?php require_once("../../config.php") ?>
<?php
if(isset($_GET['target'])) {
	$target = $_GET['target'];
	if ($target == 'comments') {
		get_comments_in_admin();
	} else if ($target == 'posts') {
		get_posts_in_admin();
	}
}

if(isset($_GET['temp'])) {
	get_temp_posts();
}

?>
