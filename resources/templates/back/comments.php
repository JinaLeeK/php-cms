<?php delete_comments_in_admin(); ?>

<div class="row">
  <h1 class="page-header">
    All comments
    <small>
      <select id="category_option" data-target="comments">
        <option value='0'>All</option>
        <?php get_category_options(); ?>
      </select>
      <select id="sub_category_option" data-target="comments">
        <option value='0'>All</option>
      </select>
    </small>
  </h1>

  <h4 class="bg-info"><?php display_message(); ?></h4>
  <form method="post" action="">
    <input type="submit" name="submit" class="btn btn-warning" onClick="javascript:return confirm('Are you sure to delete it?')" value="Delete">
    <br>
    <table class="table table-hover table-bordered admin-posts">
      <thead>
        <tr>
          <th><input type="checkbox" id="selectAllBoxes"></th>
          <th>Id</th>
          <th>Author</th>
          <th>Content</th>
          <th>In Response to</th>
          <th>Date</th>
          <th>Delete</th>
        </tr>
      </thead>

        <tbody>
          <?php get_comments_in_admin(); ?>
        </tbody>
    </table>
  </div>
</form>
 </div>
