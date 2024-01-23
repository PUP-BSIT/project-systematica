<?php
require "../../../db_conn.php";

session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT up.user_id, up.post_id, up.post_content, it.image_path
        FROM user_post up
        LEFT JOIN image_table it ON up.post_id = it.post_id
        WHERE up.user_id = ?
        ORDER BY up.created_at";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$sql_result = $stmt->get_result();

$post_list;
for ($i = 0; $sql_row = $sql_result->fetch_assoc(); $i++) {
        $post_list[$i] = array(
                'username' => get_username($sql_row['user_id']), 
                'postID' => $sql_row['post_id'],
                'postContent' => $sql_row['post_content'],
                'imagePath' => $sql_row['image_path']
        );
}

$username = get_username($sql_row['user_id']);
$response['username'] = $username;
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
