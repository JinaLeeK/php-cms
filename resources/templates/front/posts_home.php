<?php if(isset($_GET['mypost'])) {?>
	<ul class="breadcrumb">
		<li>
		<div class="form-group">
			<select id="post-status" class="form-control">
			<?php if(isset($_GET['status']) && $_GET['status']=='publish') { ?>
							<option value="0">all</option>
							<option value="publish" selected>publish</option>
							<option value="draft">draft</option>
			<?php } else if (isset($_GET['status']) &&  $_GET['status'] == 'draft') { ?>
							<option value="0">all</option>
							<option value="publish">publish</option>
							<option value="draft" selected>draft</option>
			<?php } else { ?>
							<option value="0" selected>all</option>
							<option value="publish">publish</option>
							<option value="draft" >draft</option>
			<?php } ?>
			</select>
		</div>
		</li>
	</ul>
	<div class="bg-warning"><?php display_message(); ?></div>
<?php get_my_posts() ;?>

<?php } else { ?>

<div class="content_section title">
	<ul class="breadcrumb">
		<li><a href="index.php">Home</a></li>
		<?php get_breadcrumb(); ?>
		<!-- <li><a href="posts.php?add_post&cat_id=php echo $_GET['cat_id']; ?>" class="btn btn-info btn-sm">New post</a></li> -->
	</ul>
</div>
<div class="bg-warning"><?php display_message(); ?></div>
<?php get_posts_in_category_page(); ?>
<?php }?>
