<?php delete_slide_in_admin(); ?>
  <div class="row">
    <h2>Upload photo</h2>
    <div class="bg-success"><?php display_message(); ?></div>
    <?php upload_slide_image(); ?>
     <div class="col-xs-4">
       <form class="" action="" method="post" enctype="multipart/form-data">

          <div class="form-group  preview-form">
              <input type="file" name="slide_file" accept="image/*">
          </div>
          <div id="preview_" style="overflow:hidden; width:235px;display:none; ">
            <img src="" width="100%" alt="">
          </div>

          <div class="form-group">
            <br>
             <input type="hidden" name="x1" value="" />
             <input type="hidden" name="y1" value="" />
             <input type="hidden" name="x2" value="" />
             <input type="hidden" name="y2" value="" />
             <input type="hidden" name="w" value="" />
             <input type="hidden" name="h" value="" />
             <input type="hidden" name="thumb_width" value="">
             <input type="hidden" name="thumb_height" value="">
             <input type="submit" name="upload_image" value="Save Image" style="width: 235px; display:none;" class="submit-btn btn btn-primary btn-block"/>
          </div>
        </form>
     </div>
     <div class="col-xs-8">
         <img id="thumbnail_" width="100%"  src="" alt="" />
     </div>
  </div>


<hr>

<h3>Current Slides</h3>
<div class="row">
  <?php get_slides_in_thumbnails(); ?>
</div>
