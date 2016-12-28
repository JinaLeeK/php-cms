<?php update_comment() ; ?> 
<?php include(TEMPLATE_FRONT . DS . "login_modal.php"); ?>


 <hr class="comment-hr">
<div id="comments">

	<?php get_comments_in_post_page(); ?>
	<?php add_comment(); ?>
	<div id="comment-form">
			<h4>Leave a comment</h4>
			<form class="form-horizontal" action="#" method="POST">
				<?php if(!isset($_SESSION['username'])) { ?>
					<div class="form-group">
							<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="Name" name="author">
							</div>
							<div class="col-sm-6">
									<input type="password" class="form-control" placeholder="Password" name="password">
							</div>
					</div>
				<?php } ?>
					<div class="form-group">
							<div class="col-sm-12">
									<textarea name="content" rows="3" class="form-control" placeholder="Comment"></textarea>
							</div>
					</div>
          <input type="hidden" name="category_id" value="<?php echo $row['post_category_id'];?>">
          <input type="hidden" name="sub_category_id" value="<?php echo $row['post_sub_category_id'];?>">

					<button name="submit" type="submit" class="btn btn-danger">Submit Comment</button>
			</form>
	</div><!-- /#comment-form-->
</div><!--/#comments-->
