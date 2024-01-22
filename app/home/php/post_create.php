<?php
require "../../../db_conn.php";

session_start();
$sql = "SELECT email FROM user_register WHERE username='calib'";
$sql_result = $conn->query($sql);
$sql_row = $sql_result->fetch_assoc();

$user_id = $_SESSION['user_id'];
$post_text = $_POST['post_text'];
$sql = "INSERT user_post(
                user_id, 
                post_content
        ) 
        VALUES (
                $user_id,
                '$post_text'
        )";
$sql_result = $conn->query($sql);

$response['username'] = get_username($user_id);
$response['postText'] = $post_text;
$response['success'] = true;
echo json_encode($response);

function get_username($user_id) {
        global $conn;
        $sql = "SELECT username FROM user_register WHERE user_id=$user_id";
        $sql_result = $conn->query($sql);
        $sql_row = $sql_result->fetch_assoc();
        return $sql_row['username'];
}

?>
