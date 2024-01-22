<?php
require "../../../db_conn.php";

// Assuming the post_id and new_post_text are sent in the POST request
$post_id = $_POST['post_id'];
$new_post_text = $_POST['new_post_text'];

// Use prepared statement to update the post content
$sql = "UPDATE user_post SET post_content=? WHERE post_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_post_text, $post_id);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>