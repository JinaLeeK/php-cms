<?php require_once("config.php"); ?>
<?php
if(isset($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];
	$query = query("SELECT * FROM sub_categories WHERE category_id={$cat_id}");
	confirmQuery($query);
	while($row=fetch_array($query)) {
		echo "<option value='{$row['sub_category_id']}'>{$row['sub_category_title']}</option>";
	}
}
