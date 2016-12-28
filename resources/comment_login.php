
<?php
// header('Content-Type: application/json');
require_once("config.php");
//
$id			  = $_POST['comment_id'];
$username = $_POST['username'];
$password = $_POST['password'];
$role			= $_POST['role'];

$query = query("SELECT * FROM comments WHERE comment_id = {$id} LIMIT 1");
confirmQuery($query);
$row = fetch_array($query);

$db_username = escape_string($row['comment_author']);
$db_password = escape_string($row['comment_password']);
//
if ($username === $db_username && password_verify($password, $db_password)) {
		$data = array(
			"msg"=>"ok",
			"comment_id"=>$id,
			"role"=>$role
		);

		if ($role == 'delete') {
			$query = query("DELETE FROM comments WHERE comment_id={$id}");
			confirmQuery($query);
		}
		echo json_encode($data);

} else {
		$data = array(
			"msg" =>"fail"
		);
		echo json_encode($data);

					// echo "fail";
}
// }
?>
