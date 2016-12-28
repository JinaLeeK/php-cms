<?php require_once("resources/config.php") ?>
<!-- <div class="container"> -->
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<div id="bg_top">
  <div id="wrapper">
		<?php include(TEMPLATE_FRONT . DS . "top_nav.php") ?>
    <div id="content_bg">
      <div id="content">
				<?php include(TEMPLATE_FRONT . DS . "slider.php") ?>

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
        if (isset($_GET['login'])) {
          include(TEMPLATE_FRONT . DS . "login.php");
        }
        if (isset($_GET['logout'])) {
          user_logout();
        }
        if (isset($_GET['register'])) {
          include(TEMPLATE_FRONT . DS . "register.php");
        }

        if (isset($_GET['password'])) {
          include(TEMPLATE_FRONT . DS . "password.php");
        }

        if (isset($_GET['change_password'])) {
          include(TEMPLATE_FRONT . DS . "change_password.php");

        }

        if ($_SERVER['REQUEST_URI'] == '/kids01/' || $_SERVER['REQUEST_URI']=='/kids01/index.php') {
          include(TEMPLATE_FRONT . DS . "blog_home.php");
        }

        ?>
        </div>
        <br class="clear" />
      </div> <!-- content -->
      <br class="clear" />
    </div> <!-- content_bg -->
  <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
