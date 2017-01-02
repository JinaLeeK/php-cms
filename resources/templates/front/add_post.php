<?php
if(!isset($_SESSION['username'])) {
  set_message("Please log in to write a post.");
  redirect("index.php?login");
}
?>
<?php add_post(); ?>
<div class="content_section title">
  <?php if(isset($_GET['cat_id']) || isset($_GET['id'])) { ?>
    <ul class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <?php get_breadcrumb(); ?>
    </ul>
  <?php } ?>
  <h1>Add Post</h1>
</div>
<form id="add-post-form" class="add-post-form" action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="post_title" required>
  </div>
  <div class="form-group">
    <label for="category">Category</label>
    <select id="category_option" class="category_option form-control" name="post_category_id" style="">
      <?php get_category_options(); ?>
    </select>
    <select id="sub_category_option" name="post_sub_category_id" class="category_option form-control" style="">
    </select>

  </div>

  <div class="form-group" >
    <label for="post_image">Post Image</label>
    <input type="file" accept="image/*" onChange="javascript:loadFile(event)" name="upload_photo">
  </div>
  <div class="row form-group" >
    <div class="col-sm-8" style="display:none;">
      <img id="output" width="100%" src="" >
    </div>
    <div class="col-sm-4" style="position : relative;">
      <div id="preview" style="overflow:hidden; width:164px;">
        <img width="100%" >
      </div>
      <input type="hidden" name="x1" value="" />
      <input type="hidden" name="y1" value="" />
      <input type="hidden" name="x2" value="" />
      <input type="hidden" name="y2" value="" />
      <input type="hidden" name="w" value="" />
      <input type="hidden" name="h" value="" />
      <input type="hidden" name="thumb_width" value="" />
      <input type="hidden" name="thumb_height" value="" />
      <input type="button" class="upload-btn" value="Upload" style="display: none;">
      <a href="javascript:;" class="cancel-btn" style="display:none; position: absolute; top:0; right:10px;"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea name="post_content" class="mceEditor form-control" cols="30" rows="10"></textarea>
  </div>
  <div class="text-center">
    <button type="submit" name="draft" class="btn btn-primary">Draft</button>
    <button type="submit" name="create" class="btn btn-info">Publish</button>
    <?php $href = $_SERVER['HTTP_REFERER'];?>
    <a href="<?php echo $href; ?>" class="btn btn-warning cancel-btn">Cancel</a>
  </div>

</form>
