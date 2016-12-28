<?php require_once("resources/config.php") ?>
<!-- <div class="container"> -->
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<div id="bg_top">
  <div id="wrapper">
		<?php include(TEMPLATE_FRONT . DS . "top_nav.php") ?>
    <div id="content_bg">
      <div id="content">
        <div id="news_column">
          <?php
            if(isset($_SESSION['username'])) {
                include(TEMPLATE_FRONT . DS . "user_info.php");
            }
					 include(TEMPLATE_FRONT . DS . "side_nav.php");
           include(TEMPLATE_FRONT . DS . "recent_posts.php");
         ?>
        </div>

        <div class="right_column" style="position:relative;">
        <?php
        if (isset($_GET['add_post'])) {
          include(TEMPLATE_FRONT . DS . "add_post.php");
        } else {
           include(TEMPLATE_FRONT . DS . "posts_home.php");
         }
         ?>


        </div> <!-- right_column -->
      </div> <!-- content -->
      <br class="clear" />
    </div> <!-- content_bg -->
  <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
