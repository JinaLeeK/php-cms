<?php add_category_in_admin(); ?>
<?php edit_category_in_admin(); ?>

<h1 class="page-header category-title">
  <?php $cat_ = isset($_GET['obj']) ? '':'selected'; ?>
  <a href="index.php?categories" class="<?php echo $cat_; ?>">Categories</a>
  <small>
    <?php get_cat_in_title() ?>
  </small>
</h1>
<?php
  if (!isset($_GET['edit_category'])) { ?>
    <h4 class="bg-info"><?php display_message(); ?></h4>
<?php } ?>


<div class="col-md-6">
  <?php
    if (isset($_GET['edit_category'])){

      $category_id = escape_string($_GET['edit_category']);
      if (isset($_GET['obj'])) {
        $query = query("SELECT * FROM sub_categories WHERE sub_category_id={$category_id} LIMIT 1");
      } else {
        $query = query("SELECT * FROM categories WHERE category_id={$category_id} LIMIT 1");
      }
      confirmQuery($query);
      while ($row = fetch_array($query)) {
        $category_title = isset($_GET['obj']) ? $row['sub_category_title'] : $row['category_title'];
        $category_image = isset($_GET['obj']) ? '' : $row['category_image'];
      }
      ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $category_title; ?>">
        </div>

        <div class="form-group  preview-form">
            <input type="file" name="file" accept="image/*">
          <br>
           <input type="hidden" name="x1" value="" />
           <input type="hidden" name="y1" value="" />
           <input type="hidden" name="x2" value="" />
           <input type="hidden" name="y2" value="" />
           <input type="hidden" name="w" value="" />
           <input type="hidden" name="h" value="" />
           <input type="hidden" name="thumb_width" value="">
           <input type="hidden" name="thumb_height" value="">
           <input type="submit" name="upload_image" value="Save Image" style="display:none;" class="btn btn-primary btn-block"/>
           <div id="preview-zone" style="display:none;">
             <img src="" id="thumbnail" width="100%">
             <div class="row">
               <div class="col-sm-6">
                 <input value="Save Image" id="save" class="btn btn-primary btn-block"/>
               </div>
               <div class="col-sm-6">
                 <input value="Cancel" id="cancel" class="btn btn-warning btn-block" >
               </div>
             </div>
           </div>
           <div id="preview" style="overflow:hidden; width:206px; ">
             <img src="../resources/uploads/admin/<?php echo $category_image;?>" width="100%" alt="">
           </div>
           <input style="width:206px; display:none;" value="remove" id="remove" class="btn btn-warning btn-block" />

        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary upload-btn" name="update" value="Edit" >
            <?php if(isset($_GET['obj'])) { ?>
              <a href="index.php?categories&obj=<?php echo $_GET['obj']; ?>" class="btn btn-warning">cancel</a>
            <?php } else { ?>
              <a href="index.php?categories" class="btn btn-warning upload-btn">cancel</a>
            <?php } ?>
        </div>


    </form>
    <?php } else { ?>

    <form action="" method="post" id="add-category-form" enctype="multipart/form-data">
      <div class="row">
        <div class="col-sm-10">
          <div class="form-group">
              <label for="category-title">Title</label>
              <input type="text" name="title" class="form-control" >
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label>Order</label>
            <select class="form-control" name="category_order">
              <?php get_order_option(); ?>
            </select>
          </div>
        </div>
      </div>

        <?php if(!isset($_GET['obj'])) { ?>
        <div class="form-group  preview-form">
            <!-- <input type="hidden" name="slide_id" value=""> -->
            <input type="file" name="file" accept="image/*" >
          <br>
           <input type="hidden" name="x1" value="" />
           <input type="hidden" name="y1" value="" />
           <input type="hidden" name="x2" value="" />
           <input type="hidden" name="y2" value="" />
           <input type="hidden" name="w" value="" />
           <input type="hidden" name="h" value="" />
           <input type="hidden" name="thumb_width" value="">
           <input type="hidden" name="thumb_height" value="">
           <div id="preview-zone" style="display:none;">
             <img src="" id="thumbnail" width="100%">
             <div class="row">
               <div class="col-sm-6">
                 <input value="Save Image" id="save" class="btn btn-primary btn-block"/>
               </div>
               <div class="col-sm-6">
                 <input value="Cancel" id="cancel" class="btn btn-warning btn-block" >
               </div>
             </div>
           </div>
           <div id="preview" style="overflow:hidden; width:206px;display:none; ">
             <img src="" width="100%" alt="">
           </div>
           <input style="width:206px; display:none;" value="remove" id="remove" class="btn btn-warning btn-block" />
        </div>
        <div class="form-group submit-btn" style="display:none;">
            <input type="submit" class="btn btn-primary" name="add" value="Add Category" >
        </div>
        <?php } else {?>
          <div class="form-group submit-btn" >
              <input type="submit" class="btn btn-primary" name="add" value="Add Category" >
          </div>
      <?php } ?>
    </form>
    <?php } ?>
</div>


<div class="col-md-6">
    <table class="table">
      <thead>
        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Order</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET['obj'])) {
          get_sub_cat_in_admin();
        } else
          get_cat_in_admin();
        ?>
      </tbody>
    </table>
</div>
