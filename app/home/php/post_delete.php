<?php
require "../../../db_conn.php";

$post_id = $_POST['post_id'];
$sql = "DELETE FROM user_post WHERE post_id=$post_id";
$sql_result = $conn->query($sql);
$response['success'] = true;
echo json_encode($response);
?>
