<?php require_once("resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php
if (isset($_GET['delete_post'])) {
  delete_post($_GET['delete_post']);
}
?>
<?php
  if (!isset($_GET['add_post'])) {
    $post_id = isset($_GET['edit_post']) ? $_GET['edit_post'] : $_GET['id'];
    $query = query("SELECT * FROM posts WHERE post_id={$post_id} LIMIT 1");
    confirmQuery($query);
    $row = fetch_array($query);
    $cat_title = get_cat_title_by_id($row['post_category_id'],'');
    $sub_title = get_cat_title_by_id($row['post_sub_category_id'],'sub');
  }
?>

<div id="bg_top">
  <div id="wrapper">
		<?php include(TEMPLATE_FRONT . DS . "top_nav.php") ?>
    <div id="content_bg">
      <div id="content">
        <!-- <div id="news_column">
					?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>
          ?php include(TEMPLATE_FRONT . DS . "recent_posts.php"); ?>
        </div> -->

        <!-- <div class="right_column" style="position:relative;"> -->
<div class="content_section title">
  <ul class="breadcrumb">
    <li><a href="index.php">Home</a></li>
    <li><a href="posts.php?id=<?php echo $row['post_category_id']; ?>"><?php echo $cat_title; ?></a></li>
    <li><a href="posts.php?cat_id=<?php echo $row['post_sub_category_id']; ?>"><?php echo $sub_title; ?></a></li>
    <li class="pull-right"><a href="admin/"><span class="glyphicon glyphicon-cog"></span> admin</a></li>
  </ul>
</div>
<div class="bg-info"><?php display_message(); ?> </div>

<?php
  if (isset($_GET['edit_post'])) {
    include(TEMPLATE_FRONT . DS . "edit_post.php");
  }
  if (isset($_GET['id'])) {
    include(TEMPLATE_FRONT . DS . "post_home.php");
  }
?>
        <!-- </div>  right_column -->
      </div> <!-- content -->
      <br class="clear" />
    </div> <!-- content_bg -->
  <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
