<?php edit_message() ?>

  <h1 class="page-header">
    Messages
    <?php if(!isset($_GET['edit_msg'])) { ?>
    <small><a href="index.php?messages&edit_msg"><span class="glyphicon glyphicon-edit"></span></a></small>
    <?php } ?>
  </h1>

 <?php if(isset($_GET['edit_msg'])) { ?>
  <form method="post" action="" id="edit-msg-form">
    <table class="table table-hover table-bordered admin-posts">
      <col width="20%">
      <col width="80%">
        <tbody>
          <?php get_messages_for_edit(); ?>
        </tbody>
    </table>
    <a class="pull-right btn btn-warning" href="index.php?messages">Cancel</a>
    <button class="pull-right btn btn-primary" type="submit" name="msg-edit">Edit</button>
  </form>
<?php } else { ?>

  <h4 class="bg-info"><?php display_message(); ?></h4>
    <table class="table table-hover table-bordered admin-posts">
      <col width="20%">
      <col width="80%">
        <tbody>
          <?php get_messages(); ?>
        </tbody>
    </table>
<?php } ?>
