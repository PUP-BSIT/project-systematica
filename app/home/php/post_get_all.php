<?php
require "../../../db_conn.php";

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT user_id, post_content 
        FROM user_post 
        ORDER BY created_at";
$sql_result = $conn->query($sql);
$post_list;
for ($i = 0; $sql_row = $sql_result->fetch_assoc(); $i++) {
        $post_list[$i] = array(
                'username' => get_username($sql_row['user_id']), 
                'userPost' => $sql_row['post_content']
        );
}
$response['postList'] = $post_list;
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
