<?php delete_posts_in_admin(); ?>
<?php reset_views(); ?>
<div class="row">

    <h1 class="page-header title">
      <a href="index.php?posts">All posts</a>
      <small>
        <select id="category_option" data-target="posts">
          <option value='0'>All</option>
          <?php get_category_options(); ?>
        </select>
        <select id="sub_category_option" data-target="posts">
          <option value='0'>All</option>
        </select>
      </small>
      <span class="pull-right">
        <button type="button" class="btn btn-primary temp-btn" name="button">Temp</button>
      </span>
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
            <th>Title</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Status</th>
            <!-- <th>Tags</th> -->
            <th>Comments</th>
            <th>Date</th>
            <th>Views</th>
            <th>Delete</th>
          </tr>
        </thead>

        <tbody>
          <?php get_posts_in_admin(); ?>
        </tbody>
      </table>
  </form>

</div>
