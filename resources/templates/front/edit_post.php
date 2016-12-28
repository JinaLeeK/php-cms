<?php edit_post(); ?>
<div class="content_section title">
  <h1>Edit Post</h1>
</div>

<form id="add-post-form" class="add-post-form" action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="post_title" value="<?php echo $row['post_title']; ?>">
  </div>
  <div class="form-group">
    <label for="category">Category</label>
    <select id="category_option" class="category_option form-control" name="post_category_id" style="">
      <?php
      $cat_query = query("SELECT * FROM categories");
      confirmQuery($cat_query);
      while($cat_row = fetch_array($cat_query)) {
        if ($row['post_category_id'] == $cat_row['category_id']) {
          echo "<option selected value='{$cat_row['category_id']}'>{$cat_row['category_title']}</option>";
        } else {
          echo "<option value='{$cat_row['category_id']}'>{$cat_row['category_title']}</option>";
        }
      }
      ?>
    </select>
    <select id="sub_category_option" name="post_sub_category_id" class="category_option form-control" style="">
      <?php
      $cat_query = query("SELECT * FROM sub_categories");
      confirmQuery($cat_query);
      while($cat_row = fetch_array($cat_query)) {
        if ($row['post_sub_category_id'] == $cat_row['sub_category_id']) {
          echo "<option selected value='{$cat_row['sub_category_id']}'>{$cat_row['sub_category_title']}</option>";
        } else {
          echo "<option value='{$cat_row['sub_category_id']}'>{$cat_row['sub_category_title']}</option>";
        }
      }
      ?>
    </select>

  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" accept="image/*" onChange="javascript:loadFile(event)" name="upload_photo">
  </div>
  <div class='row form-group'>
    <div class="col-sm-8" style="display:none;">
      <img id="output" width="100%" src="" >
    </div>
    <div class="col-sm-4" style="position : relative;">
      <div id="preview" style="overflow:hidden; width:164px;">
        <?php if(empty($row['post_image'])) { ?>
          <img width="100%" src="">
        <?php } else { ?>
          <img width="100%" src="resources/uploads/<?php echo $row['post_image']; ?>">
        <?php } ?>
      </div>

      <input type="hidden" name="deleteImg" value="false" />
      <input type="hidden" name="x1" value="" />
      <input type="hidden" name="y1" value="" />
      <input type="hidden" name="x2" value="" />
      <input type="hidden" name="y2" value="" />
      <input type="hidden" name="w" value="" />
      <input type="hidden" name="h" value="" />
      <input type="hidden" name="thumb_width" value="" />
      <input type="hidden" name="thumb_height" value="" />
      <input type="button" class="upload-btn" value="Upload" style="display: none;">
      <?php if(empty($row['post_image'])) { ?>
        <a href="javascript:;" class="cancel-btn" style="position: absolute; top:0; left:0px; display:none;"><span class="glyphicon glyphicon-remove"></span></a>
      <?php } else {?>
        <a href="javascript:;" class="cancel-btn" style="position: absolute; top:0; left:0px; "><span class="glyphicon glyphicon-remove"></span></a>
      <?php } ?>

    </div>

    </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea name="post_content" class="mceEditor form-control" cols="30" rows="10"><?php echo $row['post_content']; ?></textarea>
  </div>
  <div class="text-center">
    <button type="submit" name="draft" class="btn btn-primary">Draft</button>
    <button type="submit" name="update" class="btn btn-info">Update</button>
    <?php $href = $_SERVER['HTTP_REFERER'];?>
    <a href="<?php echo $href; ?>" class="btn btn-warning cancel-btn">Cancel</a>
  </div>

</form>
