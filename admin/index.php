<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_BACK . DS . "header.php") ?>
<?php
 if(!isset($_SESSION['user_role'])) {
   redirect("../index");
 }
 ?>
        <div id="page-wrapper">

            <div class="container-fluid">
                <?php
                if($_SERVER['REQUEST_URI'] === "/kids01/admin/" || $_SERVER['REQUEST_URI'] === "/kids01/admin/index.php") {
                  include(TEMPLATE_BACK . DS . "profile.php");
                };

                if(isset($_GET['posts'])) {
                  include(TEMPLATE_BACK . DS . "posts.php");
                }

                if(isset($_GET['delete_admin_post'])) {
                  delete_post($_GET['delete_admin_post']) ;
                }

                if(isset($_GET['categories']) || isset($_GET['edit_category'])) {
                  include(TEMPLATE_BACK . DS . "categories.php");
                }

                if(isset($_GET['delete_category'])) {
                  delete_category_in_admin();
                }

                if(isset($_GET['comments'])) {
                  include(TEMPLATE_BACK . DS . "comments.php");
                }

                if(isset($_GET['delete_comment'])) {
                  delete_comment_in_admin($_GET['delete_comment']);
                }

                if(isset($_GET['users'])) {
                  include(TEMPLATE_BACK . DS . "users.php");
                }

                if(isset($_GET['delete_user'])) {
                  delete_user_in_admin();
                }

                if(isset($_GET['slides'])) {
                  include(TEMPLATE_BACK . DS . "slides.php");
                }

                if(isset($_GET['messages'])) {
                  include(TEMPLATE_BACK . DS . "messages.php");
                }

                if(isset($_GET['delete_slide'])) {
                  delete_slide_in_admin();
                }

                if(isset($_GET['logout'])) {
                  echo "logout";
                  logout();
                }
                ?>

                <!--
                if(isset($_GET['orders'])) {
                  include(TEMPLATE_BACK . DS . "orders.php");
                }


                if(isset($_GET['add_product'])) {
                  include(TEMPLATE_BACK . DS . "add_product.php");
                }

                if(isset($_GET['edit_product'])) {
                  include(TEMPLATE_BACK . DS . "edit_product.php");
                }

                if(isset($_GET['categories'])) {
                  include(TEMPLATE_BACK . DS . "categories.php");
                }

                if(isset($_GET['edit_category'])) {
                  include(TEMPLATE_BACK . DS . "edit_category.php");
                }

                if(isset($_GET['users'])) {
                  include(TEMPLATE_BACK . DS . "users.php");
                }

                if(isset($_GET['add_user'])) {
                  include(TEMPLATE_BACK . DS . "add_user.php");
                }

                if(isset($_GET['edit_user'])) {
                  include(TEMPLATE_BACK . DS . "edit_user.php");
                }

                if(isset($_GET['reports'])) {
                  include(TEMPLATE_BACK . DS . "reports.php");
                }

                if(isset($_GET['delete_report'])) {
                  include(TEMPLATE_BACK . DS . "delete_report.php");
                }

                if(isset($_GET['slides'])) {
                  include(TEMPLATE_BACK . DS . "slides.php");
                }

                if(isset($_GET['delete_slide'])) {
                  include(TEMPLATE_BACK . DS . "delete_slide.php");
                }



                ?>
 -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include(TEMPLATE_BACK . DS . "footer.php") ?>
