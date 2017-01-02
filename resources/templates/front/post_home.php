<?php
$query = query("SELECT * FROM posts WHERE post_id={$_GET['id']} LIMIT 1");
confirmQuery($query);
$row = fetch_array($query);
?>
<div class="blog-item">
  <?php if (!empty($row['post_image'])) {?>
  <div class="col-xs-8 col-xs-offset-2">
    <img class="img-responsive img-blog" src="resources/uploads/<?php echo $row['post_image']; ?>" width="80%"  alt="" />
  </div>
  <br class="clear" />
  <?php }?>

  <div class="content_section">
      <div class="blog-content">
          <h2><?php echo $row['post_title']; ?></h2>
          <div class="entry-meta">
            <span><i class="icon-user"></i> <a href="#"><?php echo $row['post_author']; ?></a></span>
            <span><i class="icon-folder-close"></i> <a href="posts.php?id=<?php echo $row['post_categor_id']; ?>"><?php echo $cat_title; ?></a> / <a href="posts.php?cat_id=<?php echo $row['post_sub_category_id'];?>"><?php echo $sub_title ; ?></a></span>
            <span><i class="icon-calendar"></i> <?php echo $row['post_date']; ?></span>
            <span><i class="icon-comment"></i> <?php echo get_num_of_comments($_GET['id']);?> Comments</a></span>
            <?php if ($row['post_author'] == $_SESSION['username']) {?>
              <span class="pull-right"><i class="icon-remove"></i>
                <a onClick="javascript:return confirm('Are you sure to delete it?')" href="post.php?delete_post=<?php echo $row['post_id']; ?>"> Remove</a></span>
              <span class="pull-right"><i class="icon-edit"></i>
                <a href="post.php?edit_post=<?php echo $row['post_id']; ?>"> Edit</a></span>
            <?php } ?>
          </div>
          <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec lacus   quam. Sed ornare, augue eget aliquet vehicula, purus libero elementum   neque, vel hendrerit eros lacus non leo. </p> -->
          <p><?php echo $row['post_content']; ?></p>
<p>&nbsp;</p>
          <!-- <div class="tags">
            <i class="icon-tags"></i> Tags <a class="btn btn-xs btn-primary" href="#">CSS3</a> <a class="btn btn-xs btn-primary" href="#">HTML5</a> <a class="btn btn-xs btn-primary" href="#">WordPress</a> <a class="btn btn-xs btn-primary" href="#">Joomla</a>
          </div> -->
          <!-- <p>&nbsp;</p> -->
<?php include(TEMPLATE_FRONT . DS . "post_comments.php") ?>

      </div> <!-- blog-content -->
    <br class="clear" />
  </div> <!-- content-section -->
</div> <!-- blog-item -->
