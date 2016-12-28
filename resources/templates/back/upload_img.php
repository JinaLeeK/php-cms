<?php
$large_image_prefix = "resize_"; 			// The prefix name to large image
$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
// $max_file = "3"; 							// Maximum file size in MB
// $max_width = "500";							// Max width allowed for the large image
$thumb_width = "213";						// Width of thumbnail image
$thumb_height = "114";						// Height of thumbnail image

$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // do not change this
$image_ext = "";	// initialise variable, do not change this.
foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}

if (isset($_POST['upload'])) {
  echo $_FILES['image']['name'];
}
?>
