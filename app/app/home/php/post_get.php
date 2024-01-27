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

$post_list = array(); // Initialize $post_list as an array
$response = array(); // Initialize $response as an array
$username = get_username($user_id); // Corrected placement

while ($sql_row = $sql_result->fetch_assoc()) {
    $post_list[] = array(
        'username' => $username,
        'postID' => $sql_row['post_id'],
        'postContent' => $sql_row['post_content'],
        'imagePath' => $sql_row['image_path']
    );
}

$response['username'] = $username;
$response['postList'] = $post_list;
$response['success'] = true;
echo json_encode($response);

function get_username($user_id) {
    global $conn;
    $sql = "SELECT username FROM user_register WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sql_row = $result->fetch_assoc();
    return $sql_row['username'];
}
?>
