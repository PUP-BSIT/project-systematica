<?php
require "../../../db_conn.php";

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT post_id, post_content 
        FROM user_post 
        WHERE user_id='$user_id'
        ORDER BY created_at";
$sql_result = $conn->query($sql);
$post_list;
for ($i = 0; $sql_row = $sql_result->fetch_assoc(); $i++) {
        $post_list[$i] = array(
                'postID' => $sql_row['post_id'],
                'postContent' => $sql_row['post_content']
        );
}
$response['postList'] = $post_list;
$response['success'] = true;
echo json_encode($response);
?>
