<?php
// require "../../../db_conn.php";

// session_start();
// $sql = "SELECT email FROM user_register WHERE username='calib'";
// $sql_result = $conn->query($sql);
// $sql_row = $sql_result->fetch_assoc();

// $user_id = $_SESSION['user_id'];
// $post_text = $_POST['post_text'];
// $sql = "INSERT user_post(
//                 user_id, 
//                 post_content
//         ) 
//         VALUES (
//                 $user_id,
//                 '$post_text'
//         )";
// $sql_result = $conn->query($sql);

// $response['username'] = get_username($user_id);
// $response['postText'] = $post_text;
// $response['success'] = true;
// echo json_encode($response);

// function get_username($user_id) {
//         global $conn;
//         $sql = "SELECT username FROM user_register WHERE user_id=$user_id";
//         $sql_result = $conn->query($sql);
//         $sql_row = $sql_result->fetch_assoc();
//         return $sql_row['username'];
// }

require "../../../db_conn.php";

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle the case when the user is not logged in
    // You might want to redirect the user to a login page or show an error message
    exit("User not logged in");
}

$user_id = $_SESSION['user_id'];
$post_text = isset($_POST['post_text']) ? $_POST['post_text'] : '';

// Validate and sanitize user input (consider using more robust validation)
$post_text = $conn->real_escape_string($post_text);

// Use prepared statement to prevent SQL injection
$sql = $conn->prepare("INSERT INTO user_post (user_id, post_content) VALUES (?, ?)");
$sql->bind_param("ss", $user_id, $post_text);
$sql->execute();
$sql->close();

$response['username'] = get_username($user_id);
$response['postText'] = $post_text;
$response['success'] = true;
echo json_encode($response);

function get_username($user_id) {
    global $conn;
    $sql = "SELECT username FROM user_register WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['username'];
}
?>
