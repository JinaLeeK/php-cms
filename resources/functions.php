<?php
if(!$connection) {
	echo "<script>alert('not connected')</script>";
}

$img_path = 'resources/uploads/';
$admin_img_path = 'resources/uploads/admin/';
$slide_path = 'resources/slides/';

function escape_string($string) {
	global $connection;
	return mysqli_real_escape_string($connection, $string);
}

function last_id() {
	global $connection;

	return mysqli_insert_id($connection);
}

function set_message($msg) {
	if(!empty($msg)) {
		$_SESSION['message'] = $msg;
	} else {
		$msg = '';
	}
}

function display_message() {
	if (isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function confirmQuery($result) {
	global $connection;
	if(!$result) {
		die("Filed Query. " . mysqli_error($connection)) ;
	}
}

function redirect($location) {
	header("Location: $location");
}

function get_cat_title_by_id($id, $obj) {
	$query = $obj=='sub' ? query("SELECT * FROM sub_categories WHERE sub_category_id={$id} LIMIT 1") :
			 		 query("SELECT * FROM categories WHERE category_id={$id} LIMIT 1");
	confirmQuery($query);
	$row = fetch_array($query);
	$title = $obj=='sub'? $row['sub_category_title']:$row['category_title'];
	return $title;
}

function numOfAllRows($obj) {
	$query = query("SELECT * FROM " . $obj);
	confirmQuery($query);
	return mysqli_num_rows($query);
}

function toggle_class($obj) {
	return isset($_GET[$obj]) ? 'active' : '';
}


function query($sql) {
	global $connection;
	return mysqli_query($connection, $sql);
}

function fetch_array($result) {
	return mysqli_fetch_assoc($result);
}

// Manage users
function user_register() {
		if(isset($_POST['submit'])) {
			$username = escape_string($_POST['username']);
			$email = escape_string($_POST['email']);
			$password = escape_string($_POST['password']);
			$password2 = escape_string($_POST['password2']);
			$check = true;

			$query = query("SELECT * FROM users");
			while ($row = fetch_array($query)) {
				if ($username == $row['user_name']) {
					$check = false;
				}
			}

			if ($check) {
				$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

				$query = query("INSERT INTO users (user_name, user_password, user_role, user_email)
									VALUES('{$username}', '{$password}', 'user', '{$email}')");
				confirmQuery($query);

				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				redirect("index.php");
			} else {
					set_message("The username already exsits");
			}
		}
}

function user_login() {
	if(isset($_POST['submit'])) {
		$username = escape_string($_POST['username']);
		$password = escape_string($_POST['password']);

		$query = query("SELECT * FROM users WHERE user_name = '{$username}' LIMIT 1");
		if (mysqli_num_rows($query) === 0 ) {
			set_message("Invalid username");
		} else {
				$row = fetch_array($query);
				$db_user_id = $row['user_id'];
				$db_username = $row['user_name'];
				$db_user_role = $row['user_role'];
				$db_user_password = $row['user_password'];

				if (password_verify($password, $db_user_password)) {
					$_SESSION['username'] = $db_username;
					if ($db_user_role == 'admin') {
						$_SESSION['user_role'] = $db_user_role;
					}
					$_SESSION['password'] = $db_user_password;
					redirect("index.php");
				} else {
					set_message("Incorrect password");
				}
		}
	}
}

function user_logout() {
		session_start();
		session_destroy();
		set_message("logged out");
		redirect("index.php");
}

function get_users_in_admin() {
	$query = query("SELECT * FROM users");
	confirmQuery($query);

	while($row = fetch_array($query)) {
		$user = <<< DELIMETER
		<tr>
		 <td>{$row['user_id']}</td>
		 <td>{$row['user_name']}</td>
		 <td>{$row['user_email']}</td>
DELIMETER;
			if ($row['user_name'] == 'alex') {
				$user .= "<td><span class='glyphicon glyphicon-ok'></span></td>";
				$user .= "<td></td>";
			} else {
				if ($row['user_role'] == 'admin') {
					$user .= "<td><span class='glyphicon glyphicon-ok'></span></td>";
					$user .= "<td><a href='index.php?users={$row['user_id']}&role=user'>Unapprove</a></td>";
				} else {
					$user .= "<td></td>";
					$user .= "<td><a href='index.php?users={$row['user_id']}&role=admin'?>Approve</a></td>";
				}
			}
			$user .= <<< DELIMETER
			<td><a onClick="javascript: return confirm('Are you sure to delete this?')" href="index.php?delete_user={$row['user_id']}"><i class="glyphicon glyphicon-remove"></i></a></td>
		</tr>
DELIMETER;
		echo $user;

	}
}

function update_user_role_in_admin() {
	if(isset($_GET['role'])) {
		$user_role = escape_string($_GET['role']);
		$query = query("UPDATE users SET user_role='{$user_role}' WHERE user_id={$_GET['users']}");
		confirmQuery($query);
		set_message("User has been updated");
	}
}

function delete_user_in_admin() {
	if(isset($_GET['delete_user'])) {
		$user_id = escape_string($_GET['delete_user']);
		$query = query("DELETE FROM users WHERE user_id={$user_id}");
		confirmQuery($query);
		set_message("User has beend deleted");
		redirect("index.php?users");

	}
}


// manage categories
function add_category_in_admin() {
	if(isset($_POST['add'])) {
		$category_title = escape_string($_POST['title']);
		if (isset($_GET['obj'])) {
			$category_id = $_GET['obj'];
			$query = "INSERT INTO sub_categories ";
			$query .= "(sub_category_title, category_id) VALUES ('{$category_title}', {$category_id})";
		} else {
			$image = escape_string($_FILES['file']['name']);
			$image_temp_location = $_FILES['file']['tmp_name'];
			$order = $_POST['category_order'];

			if ($_FILES['file']['error'] != 0){
				set_message("Images must be under " . MAX_FILE_SIZE . "MB in size");
				exit();
			}

			$cat_query = query("SELECT * FROM categories");
			confirmQuery($cat_query);
			while ($row = fetch_array($cat_query)) {
				if ($row['category_order'] >= $order) {
					$update_query = query("UPDATE categories SET category_order=category_order+1 WHERE category_id={$row['category_id']}");
					confirmQuery($update_query);
				}
			}
			$image = file_exists(UPLOAD_ADMIN_DIRECTORY . DS . $image) ? 'new_'.$image : $image;
			move_uploaded_file($image_temp_location, UPLOAD_ADMIN_DIRECTORY . DS . $image);

			$image = edit_photo_in_post($image,'admin');


			$query = "INSERT INTO categories ";
			$query .= "(category_title, category_image, category_order) VALUES ('{$category_title}','{$image}', {$order})";
		}
		confirmQuery(query($query));
		set_message("Category has been added");
	}
}

function get_cat_in_home() {
	global $admin_img_path;

	$query = query("SELECT * FROM categories ORDER BY category_id LIMIT 3");
	confirmQuery($query);

	while($row = fetch_array($query)) {
		// <img src="{$admin_img_path} . {$row['category_image']}" width="100%">
		$image = $admin_img_path . $row['category_image'];
		$category = <<< DELIMETER
		<div class="col-xs-4">
			<li>
				<h4><strong><a href="posts.php?id={$row['category_id']}">{$row['category_title']}</a></strong></h4>
				<img src="$image" width="100%">
			</li>
		</div>
DELIMETER;
		echo $category;
	}
}

function edit_category_in_admin() {
	if(isset($_POST['update'])){
		$category_id = escape_string($_GET['edit_category']);
		$category_title = escape_string($_POST['title']);
		if(!isset($_GET['obj'])) {
			$image = escape_string($_FILES['file']['name']);

			$category_query = query("SELECT * FROM categories WHERE category_id={$category_id} LIMIT 1");
			confirmQuery($category_query);
			$row = fetch_array($category_query);
			$cur_image = $row['category_image'];

			if (empty($image)) {
				$image = $cur_image;
			} else {
				unlink(UPLOAD_ADMIN_DIRECTORY . DS . $cur_image);
				$image_temp_location = $_FILES['file']['tmp_name'];
				$image = file_exists(UPLOAD_ADMIN_DIRECTORY . DS . $image) ? 'new_'.$image : $image;
				move_uploaded_file($image_temp_location, UPLOAD_ADMIN_DIRECTORY . DS . $image);

				$image = edit_photo_in_post($image,'admin');
			}
			$query = query("UPDATE categories SET category_title='{$category_title}', category_image='{$image}' WHERE category_id={$category_id}");

		} else {
			$query = query("UPDATE sub_categories SET sub_category_title='{$category_title}' WHERE sub_category_id={$category_id}");
		}
		confirmQuery($query);
		set_message("Category updated");
		if (isset($_GET['obj'])) {
			redirect("index.php?categories&obj={$_GET['obj']}");
		} else {
			redirect("index.php?categories");
		}
	}
}

function delete_category_in_admin() {
	global $admin_img_path;

	if(isset($_GET['delete_category'])) {
		$category_id = escape_string($_GET['delete_category']) ;
		if (isset($_GET['obj'])) {
			$query = query("DELETE FROM sub_categories WHERE sub_category_id = {$category_id}");
			$post_query = query("UPDATE posts SET post_status='temp', post_sub_category_id='' WHERE post_sub_category_id={$category_id}");
			confirmQuery($post_query);
	 	} else {
			$image_query = query("SELECT * FROM categories WHERE category_id = {$category_id} LIMIT 1");
			confirmQuery($image_query);
			$row = fetch_array($image_query);
			$target = '../'.$admin_img_path . $row['category_image'];
			unlink($target);

			$order = $row['category_order'];
			$cat_query = query("SELECT * FROM categories");
			while($cat_row=fetch_array($cat_query)) {
				if ($cat_row['category_order']>$order) {
					$update_query = query("UPDATE categories SET category_order=category_order-1 WHERE category_id={$cat_row['category_id']}");
					confirmQuery($update_query);
				}
			}

			$query = query("DELETE FROM categories WHERE category_id = {$category_id}");
			$sub_query = query("DELETE FROM sub_categories WHERE category_id={$category_id}");
			confirmQuery($sub_query);

			$post_query = query("UPDATE posts SET post_status='temp', post_category_id='' WHERE post_category_id={$category_id}");
			confirmQuery($post_query);
		}
		confirmQuery($query);
		set_message("Category deleted");
		if(isset($_GET['obj'])) {
			redirect("index.php?categories&obj={$_GET['obj']}");
		} else {
			redirect("index.php?categories");
		}
	}
}

function get_cat_in_title() {
	$query = query("SELECT * FROM categories ORDER BY category_order DESC");
	confirmQuery($query);
	$num = mysqli_num_rows($query);
	$i = 0;
	while ($row = fetch_array($query) ) {
		if (isset($_GET['obj'])) {
			$selected = $_GET['obj']==$row['category_id']?'selected':'';
		} else {
			$selected = '';
		}

		if ($i == $num-1) {
			echo "<a class='text-gray {$selected}' href='index.php?categories&obj={$row['category_id']}'>{$row['category_title']}</a>";
		} else {
			echo "<a class='text-gray {$selected}' href='index.php?categories&obj={$row['category_id']}'>{$row['category_title']}</a> | ";
		}
		$i++;
	}
}

function get_cat_in_admin() {
	global $admin_img_path;
	$query = query("SELECT * FROM categories ORDER BY category_order ");
	confirmQuery($query);
	while ($row = fetch_array($query) ) {
		$image = '../' . $admin_img_path .$row['category_image'];
		$category = <<< DELIMETER
		<tr>
			<td>{$row['category_id']}</td>
			<td>{$row['category_title']}<br>
					<img width="100" src="{$image}">
			</td>
			<td>{$row['category_order']}</td>
			<td>
			    <a href="index.php?edit_category={$row['category_id']}"><i class="glyphicon glyphicon-edit"></i></a> &nbsp;
			    <a href="index.php?delete_category={$row['category_id']}" onClick="javascript: return confirm('Are you sure to delete it?')"><i class="glyphicon glyphicon-remove"></i></a>
			</td>
		</tr>
DELIMETER;
	echo $category;
	}
}

function get_category_title_by_id($id, $obj) {
	$query = $obj=='sub' ? query("SELECT * FROM sub_categories WHERE sub_category_id={$id} LIMIT 1")
			: query("SELECT * FROM categories WHERE category_id={$id} LIMiT 1");
	confirmQuery($query);
	$row = fetch_array($query);
	return $obj=='sub'? $row['sub_category_title'] : $row['category_title'];
}

function get_category_options() {
	$query = query("SELECT * FROM categories");
	confirmQuery($query);
	if (isset($_GET['cat_id']) || isset($_GET['id'])) {
		$cat_id = isset($_GET['id']) ? $_GET['id'] : get_cat_id_by_sub($_GET['cat_id']);
	} else {
		$cat_id = '';
	}
	while($row = fetch_array($query)) {
		if ($cat_id == $row['category_id']) {
			echo "<option selected value='{$row['category_id']}'>{$row['category_title']}</option>";
		} else {
			echo "<option value='{$row['category_id']}'>{$row['category_title']}</option>";
		}
	}
}

function get_sub_cat_in_admin() {
	$category_id = escape_string($_GET['obj']);
	$query = query("SELECT * FROM sub_categories WHERE category_id={$category_id}");
	confirmQuery($query);

	while ($row = fetch_array($query) ) {
		$category = <<< DELIMETER
		<tr>
			<td>{$row['sub_category_id']}</td>
			<td>{$row['sub_category_title']}</td>
			<td>
			    <a href="index.php?edit_category={$row['sub_category_id']}&obj={$category_id}"><i class="glyphicon glyphicon-edit"></i></a> &nbsp;
			    <a href="index.php?delete_category={$row['sub_category_id']}&obj={$category_id}" onClick="javascript: return confirm('Are you sure to delete it?')"><i class="glyphicon glyphicon-remove"></i></a>
			</td>
		</tr>
DELIMETER;
	echo $category;
	}
}

function get_cat_id_by_sub($sub_id) {
	$query = query("SELECT * FROM sub_categories WHERE sub_category_id={$sub_id}");
	confirmQuery($query);
	$row = fetch_array($query);
	return $row['category_id'];
}

function get_cat_in_top_nav() {
	if (isset($_GET['cat_id'])) {
		$current_cat = get_cat_id_by_sub($_GET['cat_id']);
	}
	$query = query("SELECT * FROM categories ORDER BY category_order");
	confirmQuery($query);
	while($row = fetch_array($query)) {
		if (isset($current_cat) && $current_cat==$row['category_id']) {
			$active = 'active';
		} else {
			$active = '';
		}
		$sub_query = query("SELECT * FROM sub_categories WHERE category_id={$row['category_id']}");
		confirmQuery($sub_query);

		if (mysqli_num_rows($sub_query)>0) {
			echo "<li><a href='#' class='{$active}'>{$row['category_title']}</a>";
			echo "<ul class='second-level'>";

			while ($sub_row = fetch_array($sub_query) ) {
				echo "<li><a href='posts.php?cat_id={$sub_row['sub_category_id']}'>{$sub_row['sub_category_title']}</a></li>";
			}
			echo "</ul></li>";
		} else {
			echo "<li><a href='posts.php?id={$row['category_id']}' class='{$active}'>{$row['category_title']}</a>";
		}
	}
}

function get_cat_in_side_nav() {
	if (isset($_GET['cat_id'])) {
		$current_cat = get_cat_id_by_sub($_GET['cat_id']);
	}

	$query = query("SELECT * FROM categories ORDER BY category_order");
	confirmQuery($query);

	while($row = fetch_array($query)) {
		$href = "#".$row['category_id'];
		$category = <<< DELIMETER
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordian" href="{$href}">
						<span class="badge_ pull-right" id=""><i class="icon-plus"></i></span>
DELIMETER;
     if (isset($current_cat) && $current_cat==$row['category_id']) {
			 $category .= "<strong>" . $row['category_title'] . "</strong>";
		 } else {
			 $category .= $row['category_title'];
		 }
		 $category .= <<< DELIMETER
					</a>
				</h4>
			</div>
			<div id="{$row['category_id']}" class="panel-collapse collapse">
				<div class="panel-body">
					<ul>
DELIMETER;
			echo $category;
			$sub_query = query("SELECT * FROM sub_categories WHERE category_id={$row['category_id']}");
			confirmQuery($sub_query);
			while ($sub_row = fetch_array($sub_query)) {
				echo "<li><a href='posts.php?cat_id={$sub_row['sub_category_id']}'>{$sub_row['sub_category_title']}</a></li>";
			}
			$category = <<< DELIMETER
					</ul>
				</div>
			</div>
		</div>
DELIMETER;
			echo $category;
	}
}

function get_breadcrumb() {
	$cat_id = isset($_GET['id']) ? $_GET['id'] : get_cat_id_by_sub($_GET['cat_id']);
	$title = get_cat_title_by_id($cat_id,'');
	echo "<li><a href='posts.php?id={$cat_id}'>{$title}</a></li>";

	if (isset($_GET['cat_id'])) {
		$sub_cat_id = $_GET['cat_id'];
		$sub_title = get_cat_title_by_id($sub_cat_id, 'sub');
		echo "<li><a href='posts.php?cat_id={$sub_cat_id}'>{$sub_title}</a></li>";
	}

	if (isset($_GET['id'])) {
		echo "<li><a href='posts.php?add_post&id={$cat_id}' class='btn btn-info btn-sm'>New post</a></li>";
	} else {
		echo "<li><a href='posts.php?add_post&cat_id={$sub_cat_id}' class='btn btn-info btn-sm'>New post</a></li>";
	}
}

// manage post
function add_post() {
	if (isset($_POST['create']) || isset($_POST['draft'])) {
		$title = escape_string($_POST['post_title']);
		$category_id = escape_string($_POST['post_category_id']);
		$sub_category_id = escape_string($_POST['post_sub_category_id']);
		$content = escape_string($_POST['post_content']);
		$image = escape_string($_FILES['upload_photo']['name']);
		$image_temp_location = $_FILES['upload_photo']['tmp_name'];
		$status = isset($_POST['create']) ? 'publish' : 'draft';
		$username = $_SESSION['username'];
		$date = date("Y-m-d h:i:sa");

		if (!empty($image)){
			if ($_FILES['upload_photo']['error'] != 0){
				echo $_FILES['upload_photo']['error'];
				set_message("Images must be under " . MAX_FILE_SIZE . "MB in size");
				// redirect("posts.php?add_post&id={$_GET['id']}");
				exit();
			}

			$image = file_exists(UPLOAD_DIRECTORY . DS . $image) ? 'new_'.$image : $image;
			move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);

			$image = edit_photo_in_post($image,'post');
		}
		$query = query("INSERT INTO posts (post_title, post_category_id, post_sub_category_id,
										post_content, post_image, post_status, post_views_count, post_author, post_date)
										VALUES ('{$title}', {$category_id}, {$sub_category_id}, '{$content}', '{$image}',
										'{$status}', 0, '{$username}', '{$date}')");
		confirmQuery($query);
		$last_id = last_id();
		if (!empty($last_id)) {
			redirect("post.php?id={$last_id}");
		}
	}
}

function edit_photo_in_post($image, $obj) {
	$new_image = '_'.$image;
	$dir = $obj=='admin' ? UPLOAD_ADMIN_DIRECTORY : UPLOAD_DIRECTORY;
	$dir = $obj=='slide' ? SLIDES_DIRECTORY : $dir;

	$filename= $dir . DS . $image;
	$new_filename = $dir . DS . $new_image;

	list($origin_width, $origin_height, $imageType) = getimagesize($filename);
	$scale = $origin_width / $_POST['thumb_width'];

	$imageType = image_type_to_mime_type($imageType);

	$x1 = $_POST['x1'] * $scale;
	$x2 = $_POST['x2'] * $scale;
	$y1 = $_POST['y1'] * $scale;
	$y2 = $_POST['y2'] * $scale;
	$w = $_POST['w'] * $scale;
	$h = $_POST['h'] * $scale;

	$new = imagecreatetruecolor($w, $h);

	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($filename);
			break;
			case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($filename);
			break;
			case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($filename);
			break;
		}

		imagecopyresampled($new , $source, 0, 0, $x1,$y1, $w, $h, $w, $h);

		switch($imageType) {
			case "image/gif":
					imagegif($new, $new_filename);
				break;
					case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
					imagejpeg($new, $new_filename, 90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($new, $new_filename);
				break;
		}

		chmod($new_filename, 0777);
		unlink($dir . DS . $image);
		return $new_image;
}

function get_my_posts() {
	global $img_path;
	if (isset($_GET['status'])) {
		$query = query("SELECT * FROM posts WHERE post_author='{$_SESSION['username']}' AND post_status='{$_GET['status']}'");
	} else {
		$query = query("SELECT * FROM posts WHERE post_author='{$_SESSION['username']}' AND NOT post_status='temp'");
	}
	confirmQuery($query);

	while ($row = fetch_array($query)) {
		if (empty($row['post_image'])) {
			$post_content = strlen($row['post_content'])>300 ? substr($row['post_content'],0,300).' ...' : $row['post_content'];
			$post = <<< DELIMETER
			<div class="case_study_box_container" style="border-top:1px solid #e7e7e7;">
				<div class="col-xs-12 text">
					<div id="date-writer-hit"><em><span class="glyphicon glyphicon-time"></span> {$row['post_date']} by {$row['post_author']}</em></div>
					<h2>{$row['post_title']}</h2>
					<p>{$post_content}</p>
					<a href="post.php?id={$row['post_id']}" class="pull-right btn btn-inverse">Read More &gt; </a>
				</div>
				<hr class="clear" />
			</div>
DELIMETER;
		echo $post;
		} else {
			$image = $img_path . $row['post_image'];
			$post_content = strlen($row['post_content'])>100 ? substr($row['post_content'],0,100).' ...' : $row['post_content'];
			$post = <<< DELIMETER
			<div class="case_study_box_container" style="border-top:1px solid #e7e7e7;">
				<div class="col-xs-4 image"> <img src="{$image}" alt="1"  width="100%"/> </div>
				<div class="col-xs-8 text">
					<div id="date-writer-hit"><em><span class="glyphicon glyphicon-time"></span> {$row['post_date']} by {$row['post_author']}</em></div>
					<h2>{$row['post_title']}</h2>
					<p>{$post_content}</p>
					<a href="post.php?id={$row['post_id']}" class="pull-right btn btn-inverse">Read More &gt; </a>
				</div>
				<hr class="clear" />
			</div>
DELIMETER;
			echo $post;
		}
	}
}

function get_posts_in_category_page() {
	global $img_path;
	$query = isset($_GET['cat_id']) ? query("SELECT * FROM posts WHERE post_sub_category_id={$_GET['cat_id']}") :
		query("SELECT * FROM posts WHERE post_category_id={$_GET['id']} AND post_status='publish'");

	confirmQuery($query);
	if (mysqli_num_rows($query) < 1) {
		echo "<h4>No Post Yet</h4>";
	} else {
		while ($row = fetch_array($query)) {
			if (empty($row['post_image'])) {
				$post_content = strlen($row['post_content'])>300 ? substr($row['post_content'],0,300).' ...' : $row['post_content'];
				$post = <<< DELIMETER
				<div class="case_study_box_container" style="border-top:1px solid #e7e7e7;">
					<div class="col-xs-12 text">
						<div id="date-writer-hit"><em><span class="glyphicon glyphicon-time"></span> {$row['post_date']} by {$row['post_author']}</em></div>
						<h2>{$row['post_title']}</h2>
						<p>{$post_content}</p>
						<a href="post.php?id={$row['post_id']}" class="pull-right btn btn-inverse">Read More &gt; </a>
					</div>
					<hr class="clear" />
				</div>
DELIMETER;
			echo $post;
			} else {
				$image = $img_path . $row['post_image'];
				$post_content = strlen($row['post_content'])>100 ? substr($row['post_content'],0,100).' ...' : $row['post_content'];
				$post = <<< DELIMETER
				<div class="case_study_box_container" style="border-top:1px solid #e7e7e7;">
					<div class="col-xs-4 image"> <img src="{$image}" alt="1"  width="100%"/> </div>
					<div class="col-xs-8 text">
						<div id="date-writer-hit"><em><span class="glyphicon glyphicon-time"></span> {$row['post_date']} by {$row['post_author']}</em></div>
						<h2>{$row['post_title']}</h2>
						<p>{$post_content}</p>
						<a href="post.php?id={$row['post_id']}" class="pull-right btn btn-inverse">Read More &gt; </a>
					</div>
					<hr class="clear" />
				</div>
DELIMETER;
				echo $post;
			}
		}
	}
}

function get_temp_posts() {
	global $img_path;
	$query = query("SELECT * FROM posts WHERE post_status='temp'");
	confirmQuery($query);

	while ($row= fetch_array($query)) {
		$title = empty($row['post_category_id'])?'':get_category_title_by_id($row['post_category_id'],'');
		$title = empty($title) ? 'deleted' : "<a href='../posts.php?id={$row['post_category_id']}'>{$title}</a>";
		$sub_title = empty($row['post_sub_category_id'])? '':get_category_title_by_id($row['post_sub_category_id'], 'sub');
		$sub_title = empty($sub_title) ? 'deleted' : "<a href='../posts.php?cat_id={$row['post_sub_category_id']}'>{$sub_title}</a>";
		$comments_count = get_num_of_comments($row['post_id']);
		$post = <<< DELIMETER
		<tr>
		<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='{$row['post_id']}'></td>
		<td>{$row['post_id']}</td>
		<td>{$row['post_author']}</td>
		<td><a href='../post.php?id={$row['post_id']}'>{$row['post_title']}</a><br>
DELIMETER;
		if (!empty($row['post_image'])) {
			$image = "../" . $img_path . $row['post_image'];
			$post .= "<img width='120' src='{$image}'>";
		}
		$post .= <<< DELIMETER
		</td>
		<td>{$title}</td>
		<td>{$sub_title}</td>
		<td>{$row['post_status']}</td>
		<td><a href="../post.php?id={$row['post_id']}">{$comments_count}</a></td>
		<td>{$row['post_date']}</td>
		<td><a href="index.php?posts&reset={$row['post_id']}" onClick="javascript: return confirm('Are you sure to reset it?')">{$row['post_views_count']}</a></td>
		<td><a href="index.php?delete_post={$row['post_id']}" onClick="javascript: return confirm('Are you sure to delete this post?')">Delete</a></td>
		</tr>
DELIMETER;
	echo $post;
	}
}

function get_posts_in_admin() {
	global $img_path;
	if (isset($_GET['sub_cat_id']) && $_GET['sub_cat_id'] != 0) {
		$query = query("SELECT * FROM posts WHERE post_sub_category_id={$_GET['sub_cat_id']} AND NOT post_status='temp' ORDER BY post_id DESC");
	} else {
		$query = (isset($_GET['cat_id'])&&$_GET['cat_id']!=0) ? query("SELECT * FROM posts WHERE post_category_id={$_GET['cat_id']} AND NOT post_status='temp' ORDER BY post_id DESC") :
			query("SELECT * FROM posts ORDER BY post_id DESC") ;
	}
	confirmQuery($query);
	while ($row = fetch_array($query)) {
		$title = get_category_title_by_id($row['post_category_id'],'');
		$sub_title = get_category_title_by_id($row['post_sub_category_id'], 'sub');
		$comments_count = get_num_of_comments($row['post_id']);
		$post = <<< DELIMETER
		<tr>
		<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='{$row['post_id']}'></td>
		<td>{$row['post_id']}</td>
		<td>{$row['post_author']}</td>
		<td><a href='../post.php?id={$row['post_id']}'>{$row['post_title']}</a><br>
DELIMETER;
		if (!empty($row['post_image'])) {
			$image = "../" . $img_path . $row['post_image'];
			$post .= "<img width='120' src='{$image}'>";
		}
		$post .= <<< DELIMETER
		</td>
		<td>{$title}</td>
		<td><a href='../posts.php?cat_id={$row['post_sub_category_id']}'>{$sub_title}</a></td>
		<td>{$row['post_status']}</td>
		<td><a href="../post.php?id={$row['post_id']}">{$comments_count}</a></td>
		<td>{$row['post_date']}</td>
		<td><a href="index.php?posts&reset={$row['post_id']}" onClick="javascript: return confirm('Are you sure to reset it?')">{$row['post_views_count']}</a></td>
		<td><a href="index.php?delete_post={$row['post_id']}" onClick="javascript: return confirm('Are you sure to delete this post?')">Delete</a></td>
		</tr>
DELIMETER;
	echo $post;
	}
}

function edit_post() {
	if(isset($_POST['update']) || isset($_POST['draft'])) {
		$id = escape_string($_GET['edit_post']);
		$title = escape_string($_POST['post_title']);
		$category_id = escape_string($_POST['post_category_id']);
		$sub_category_id = escape_string($_POST['post_sub_category_id']);
		$content = escape_string($_POST['post_content']);
		$image = escape_string($_FILES['upload_photo']['name']);
		$image_temp_location = $_FILES['upload_photo']['tmp_name'];
		$status = isset($_POST['update']) ? 'publish' : 'draft';
		$username = $_SESSION['username'];
		$date = date("Y-m-d h:i:sa");
		$isDeleted = $_POST['deleteImg'];

		$get_pic = query("SELECT post_image FROM posts WHERE post_id={$id} LIMIT 1");
		confirmQuery($get_pic);
		$pic = fetch_array($get_pic) ;
		$pre_image = $pic['post_image'];

		if ($isDeleted) {
			unlink(UPLOAD_DIRECTORY . DS . $pre_image);
			if (!empty($image)) {
				$image = file_exists(UPLOAD_DIRECTORY . DS . $image) ? 'new_'.$image : $image;
				move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
				$image = edit_photo_in_post($image,'post');
			}
		} else {
			$image = $pre_image;
		}


			$query = "UPDATE posts SET ";
			$query .= "post_title = '{$title}', ";
			$query .= "post_category_id = '{$category_id}', ";
			$query .= "post_sub_category_id = '{$sub_category_id}', ";
			$query .= "post_content = '{$content}', ";
			$query .= "post_image = '{$image}', ";
			$query .= "post_status = '{$status}', ";
			$query .= "post_author = '{$username}', ";
			$query .= "post_date = '{$date}' ";
			$query .= "WHERE post_id = {$id}";

			$update_query = query($query);
			confirmQuery($update_query);

			set_message(" Post has been updated!");
			redirect("post.php?id={$id}");
	}
}

function delete_post($id) {
	$post_query = query("SELECT * FROM posts WHERE post_id = {$id} LIMIT 1");
	confirmQuery($post_query);
	$row = fetch_array($post_query);
	$sub_cat_id = $row['post_sub_category_id'];

	if(!empty($row['post_image'])) {
		$target_path = UPLOAD_DIRECTORY . DS . $row['post_image'];
		unlink($target_path);
	};

	$query = query("DELETE FROM posts WHERE post_id = {$id}");
	confirmQuery($query);

	$comment_query = query("DELETE FROM comments WHERE comment_post_id = {$id}");
	confirmQuery($comment_query);

	if(isset($_GET['delete_post'])) {
		set_message("post has been deleted");
		redirect("posts.php?cat_id={$sub_cat_id}");
	}
}

function get_recent_posts() {
	$query = query("SELECT * FROM posts WHERE post_status='publish' ORDER BY post_date DESC LIMIT 3");
	confirmQuery($query);

	while ($row = fetch_array($query) ) {
		$date = strtotime($row['post_date']);
		$date_yy = date('Y', $date);
		$date_mm = date('M', $date);
		$date_dd = date('d', $date);
		$content = substr($row['post_content'],0,200);
		echo "<li>";
		$post = <<< DELIMETER
		<div class='date'><span class='size24'>{$date_dd}</span><br />
			<span class="size18">{$date_mm}</span> {$date_yy}</div>
		<div class="text"><strong><a href="post.php?id={$row['post_id']}" class="title" >{$row['post_title']}</a></strong> {$content}</div>
DELIMETER;
		echo $post . "</li>";

	}
}

function delete_posts_in_admin() {
	if(isset($_POST['submit'])) {
		if (isset($_POST['checkBoxArray'])) {
			foreach($_POST['checkBoxArray'] as $postValueId){
				delete_post($postValueId);
			}
			set_message("Posts Deleted");
		}
	}
}


function reset_views() {
	if(isset($_GET['reset'])) {
		$post_id = escape_string($_GET['reset']);
		$query = query("UPDATE posts SET post_views_count = 0 WHERE post_id={$post_id}");
		confirmQuery($query);
	}
}

// manage comments
function get_num_of_comments($post_id) {
	$query = query("SELECT * FROM comments WHERE comment_post_id = " . $post_id);
	confirmQuery($query);
	return mysqli_num_rows($query);
}

function get_comments_in_post_page() {
	$id = $_GET['id'];
	$query = query("SELECT * FROM comments WHERE comment_post_id={$id}");
	confirmQuery($query);

	while ($row= fetch_array($query)) {
		$comment = <<<DELIMETER
		<div class="comments">
			<span class="writer">{$row['comment_author']}</span>
			<span class="date">{$row['comment_date']}</span>
			<span class="modify-del" style="">
			<a class="comment_login" href="#editModal" data-toggle="modal" data-id="{$row['comment_id']}" data-role="modify" ><span class="glyphicon glyphicon-edit"></span></a>
			| <a class="comment_login" href="#editModal" data-toggle="modal" data-id="{$row['comment_id']}" data-role="delete"><span class="glyphicon glyphicon-remove"></a>
			</span>
			<p>{$row['comment_content']}</p>

			<form id="modifyCommentForm{$row['comment_id']}" class="modify-comment" method="post" style="display:none;">
				<input type="hidden" name="comment_id" value="{$row['comment_id']}" />
				<div class="form-group editComment">
				 <textarea autofocus class="form-control" name="content" rows="3">{$row['comment_content']}</textarea>
				</div>
				<div class="pull-right">
					<button class="modify-btn btn btn-sm btn-primary" type='submit' name='update_comment'>modify</button>&nbsp;
					<button class='btn btn-sm btn-danger modifyCommentToggle'>cancel</button>
				</div>
				<p>&nbsp;</p>
			</form>

			<hr class="comment-hr">
	</div>
DELIMETER;
	echo $comment;
	}
}

function get_comments_in_admin() {
	if (isset($_GET['sub_cat_id']) && $_GET['sub_cat_id'] != 0) {
		$query = query("SELECT * FROM comments WHERE comment_sub_category_id={$_GET['sub_cat_id']} ORDER BY comment_id DESC");
	} else {
		$query = (isset($_GET['cat_id'])&&$_GET['cat_id']!=0) ? query("SELECT * FROM comments WHERE comment_category_id={$_GET['cat_id']} ORDER BY comment_id DESC") :
			query("SELECT * FROM comments ORDER BY comment_id DESC") ;
	}
	confirmQuery($query);

	while($row = fetch_array($query)) {
		$post_query = query("SELECT * FROM posts WHERE post_id={$row['comment_post_id']} LIMIT 1");
		confirmQuery($post_query);
		$post_row = fetch_array($post_query);
		$comment_post_title = $post_row['post_title'];

		$comment = <<< DELIMETER
		<tr>
			<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='{$row['comment_id']}'></td>
			<td>{$row['comment_id']}</td>
			<td>{$row['comment_author']}</td>
			<td><a href="../post.php?id={$row['comment_post_id']}">{$row['comment_content']}</a></td>
			<td><a href="../post.php?id={$row['comment_post_id']}">{$comment_post_title}</a></td>
			<td>{$row['comment_date']}</td>
			<td><a onClick="javascript: return confirm('Are you sure to delete it?')" href="index.php?delete_comment={$row['comment_id']}">delete</a></td>
DELIMETER;
		echo $comment;
	}
}

function update_comment() {
	if(isset($_POST['update_comment'])) {
		$id = escape_string($_POST['comment_id']);
		$content = escape_string($_POST['content']);
		$date = date("Y-m-d h:i:sa");

		$query = "UPDATE comments SET comment_content='{$content}', ";
		$query .= "comment_date = '{$date}' WHERE comment_id = {$id}";
		$result = query($query);
		confirmQuery($result);
		set_message("Comment has been updated");
	}
}

function add_comment() {
	if(isset($_POST['submit'])) {
		$content = escape_string($_POST['content']);
		$post_id = escape_string($_GET['id']);
		$date = date("Y-m-d h:i:sa");

		$author = isset($_SESSION['username']) ? $_SESSION['username']:escape_string($_POST['username']);
		$password = isset($_SESSION['password']) ? $_SESSION['password']:escape_string($_POST['password']);
		$password = isset($_SESSION['password']) ? $password : password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
		$cat_id = $_POST['category_id'];
		$sub_cat_id = $_POST['sub_category_id'];

			$query = "INSERT INTO comments ";
			$query .= "(comment_author, comment_password, comment_content, ";
			$query .= "comment_post_id, comment_date, comment_category_id, comment_sub_category_id) ";
			$query .= "VALUES('{$author}', '{$password}', '{$content}', ";
			$query .= "'{$post_id}', '{$date}', {$cat_id}, {$sub_cat_id}) ";

			$add_comment_query = query($query);
			confirmQuery($add_comment_query);
			set_message("Comment has been added!");
			redirect("post.php?id=" . $post_id);
	}
}

function delete_comment_in_admin($id) {
	// $comment_id = escape_string($_GET['delete_comment']);
	$query = query("DELETE FROM comments WHERE comment_id = {$id}");
	confirmQuery($query);
	set_message("Comment has been deleted");
	redirect("index.php?comments");
}

function delete_comments_in_admin() {
	if(isset($_POST['submit'])) {
		if (isset($_POST['checkBoxArray'])) {
			foreach($_POST['checkBoxArray'] as $commentValueId){
				$query = query("DELETE FROM comments WHERE comment_id={$commentValueId}");
				confirmQuery($query);

				// redirect("index.php?posts");
			}
			set_message("Comments have been deleted");
		}
	}
}

// manage slides
function upload_slide_image() {
	if(isset($_POST['upload_image'])) {
		$query = query("SELECT * FROM slides");
		confirmQuery($query);
		if (mysqli_num_rows($query) >= 4) {
			set_message("Slides image can be saved maximum 4. Please delete some current images to save new one.");
			redirect("index.php?slides");
			exit();
		}
		$image = escape_string($_FILES['slide_file']['name']);
		$image_temp_location = $_FILES['slide_file']['tmp_name'];

		if($_FILES['slide_file']['error'] != 0) {
			set_message("Something error occured. Try again.");
			exit();
		}

		$image = file_exists(SLIDES_DIRECTORY . DS . $image) ? '_'.$image : $image;
		move_uploaded_file($image_temp_location, SLIDES_DIRECTORY . DS . $image);

		$image = edit_photo_in_post($image,'slide');

		$query = query("INSERT INTO slides (slide_image) VALUES ('{$image}')");
		confirmQuery($query);
	}
}

function get_slides_in_thumbnails() {
	global $slide_path;
	$query = query("SELECT * FROM slides ORDER BY slide_id ASC");
	confirmQuery($query);

	while($row = fetch_array($query)) {
		$image = '../'. $slide_path . $row['slide_image'];
		$slide_thumb_admin = <<< DELIMETER
		<div class="col-sm-6 col-md-3" style="">
		 <div data-id={$row['slide_id']} class="thumbnail">
				<img data-id="{$row['slide_id']}" src="{$image}">
				<div class="caption">
						<div>
							<a onClick="javascript: return confirm('Are you sure to delete it?');" href="index.php?slides&delete_slide={$row['slide_id']}" class="btn btn-warning btn-block" width="" role="button">Delete</a>
						</div>
						<div class="clear" style="clear: both;"></div>
				</div>
			</div>
		</div>
DELIMETER;
		echo $slide_thumb_admin;
	}
}

function delete_slide_in_admin() {
	if(isset($_GET['delete_slide'])) {
		$slide_id = escape_string($_GET['delete_slide']);
		$query_find_image = query("SELECT * FROM slides WHERE slide_id={$slide_id} LIMIT 1");
		confirmQuery($query_find_image);
		$image_row = fetch_array($query_find_image);
		$target_path = SLIDES_DIRECTORY . DS . $image_row['slide_image'];
		unlink($target_path);

		$query = query("DELETE FROM slides WHERE slide_id={$slide_id}");
		confirmQuery($query);

	}
}

function get_carousel_in_front_page() {
	$query = query("SELECT * FROM slides");
	confirmQuery($query);
	$num = mysqli_num_rows($query); $i=0;
	while ($row = fetch_array($query)) {
		if ($i==0) {
			echo "<li data-target='#head-photo-slides' data-slide-to='{$i}' class='active'></li>";
		} else {
			echo "<li data-target='#head-photo-slides' data-slide-to='{$i}'></li>";
		}
		$i++;
	}
}

function get_slides_in_front_page() {
	global $slide_path;
	$query = query("SELECT * FROM slides");
	confirmQuery($query);
	$isFirst = true;
	while ($row = fetch_array($query)) {
		$active = $isFirst ? 'active' : '';
		$image = $slide_path . $row['slide_image'];
		$slide = <<< DELIMETER
		<div class="item {$active}">
			<img class="img-responsive" src="{$image}">
		</div>
DELIMETER;
		echo $slide;
		$isFirst = false;
	}
}

function get_order_option() {
	$query = query("SELECT * FROM categories");
	$num = mysqli_num_rows($query);
	for ($i=0; $i<$num; $i++) {
		$order = $i+1;
		echo "<option val='{$order}'>$order</option>";
	}
	$order = $num+1;
	echo "<option val='$order'>$order</option>";
}

// manage password
function get_password_in_user() {
	if(isset($_SESSION['password_confirm']) ) { unset($_SESSION['password_confirm']); }
	if(isset($_POST['get_password'])) {
		$username = escape_string($_POST['username']);
		$email    = escape_string($_POST['email']);

		$query = query("SELECT * FROM users WHERE user_name='{$username}' LIMIT 1");
		confirmQuery($query);
		$count = mysqli_num_rows($query);

		if ($count == 1 ) {
			$row = fetch_array($query);
			if ($email == $row['user_email']) {
				send_email_for_password($username, $email);
			} else {
				set_message("The email doesn't match.");
			}
		} else {
			set_message("The username doesn't match.");
		}
	}
}

function send_email_for_password($username, $email) {
	$emailcut = substr($email, 0 , 4);
	$randNum = rand(10000, 99999);
	$tempPass = "$emailcut$randNum";
	$password = password_hash($tempPass, PASSWORD_BCRYPT, array('cost' => 12)) ;

	$update_query = query("UPDATE users set user_password='{$password}' WHERE user_name='{$username}'");
	confirmQuery($update_query);

	$to = "$email";
	$from = "auto_responder@yoursite.com";
	$headers = "From: $from\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
	$subject =  "yoursite Temporary Password";
	$msg = '<h2>Hello</h2><p>This is an automated message from yoursite. ';
	$msg .= '<p>You indicated that you forgot your login password. We can generate ';
	$msg .= 'a temporary password for you to log in with, then once logged in you can ';
	$msg .= 'change your password to anything you like.</p>';
	$msg .= '<p>After you click the link below your password to login will be:<br /><b>'.$tempPass.'</><p>';
	$msg .= '<p><a href="https://jinalee.000webhostapp.com/index.php?login">Click here now to apply the temporary password shown below to your account</a></p>';

	if(mail($to, $subject, $msg, $headers)) {
		$_SESSION['password_confirm'] = false;
		set_message("Email has been sent");

	}

}

function change_password_in_user() {
	if (isset($_POST['change_password'])) {
		$username = escape_string($_SESSION['username']);
		$oldpassword = escape_string($_POST['oldpassword']);
		$newpassword = escape_string($_POST['newpassword']);
		$repeatpassword = escape_string($_POST['repeatnewpassword']);

		$user_query = query("SELECT * FROM users where user_name = '{$username}' LIMIT 1");
		confirmQuery($user_query);
		$row = fetch_array($user_query);

		if (password_verify($oldpassword, $row['user_password']) ) {
			if ($newpassword == $repeatpassword) {
				$password = password_hash($newpassword, PASSWORD_BCRYPT, array('cost' => 12));
				$query = query("UPDATE users SET user_password='$password' WHERE user_name='{$username}'");
				confirmQuery($query);

				set_message("password has been changed");
				redirect("index.php");
			} else {
				set_message("New password doesn't match.");
			}

		} else {
			set_message("Current password doesn't match.");
		}
	}
}

?>
