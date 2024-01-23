<?php
// require "../../../db_conn.php";

// // Assuming the post_id and new_post_text are sent in the POST request
// $post_id = $_POST['post_id'];
// $new_post_text = $_POST['new_post_text'];

// // Use prepared statement to update the post content
// $sql = "UPDATE user_post SET post_content=? WHERE post_id=?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("si", $new_post_text, $post_id);

// $response = array();

// if ($stmt->execute()) {
//     $response['success'] = true;
// } else {
//     $response['success'] = false;
//     $response['error'] = $stmt->error;
// }

// $stmt->close();
// $conn->close();

// echo json_encode($response);

require "../../../db_conn.php";

session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT up.user_id, up.post_content, it.image_path
        FROM user_post up
        LEFT JOIN image_table it ON up.post_id = it.post_id
        ORDER BY up.created_at";
        
$sql_result = $conn->query($sql);
$post_list;
for ($i = 0; $sql_row = $sql_result->fetch_assoc(); $i++) {
        $post_list[$i] = array(
                'username' => get_username($sql_row['user_id']), 
                'userPost' => $sql_row['post_content'],
                'imagePath' => $sql_row['image_path']
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