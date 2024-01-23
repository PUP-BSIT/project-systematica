<?php
require "../../../db_conn.php";

session_start();

// Check if authorization token is provided
if (isset($_POST['authorization_token']) && !empty($_POST['authorization_token'])) {
    $authorizationToken = $_POST['authorization_token'];

    // Validate authorization token
    if (!validateAuthorizationToken($authorizationToken)) {
        http_response_code(401); // Unauthorized
        $response['error_message'] = "Unsuccessful Authorization!";
        echo json_encode($response);
        exit;
    }
}

// Authorization token not required or valid, proceed with post creation
$user_id = $_SESSION['user_id'];
$post_text = isset($_POST['post_text']) ? $_POST['post_text'] : '';

// Check if post content is provided
if (empty($post_text)) {
    http_response_code(400); // Bad Request
    $response['error_message'] = "Post content is required.";
    echo json_encode($response);
    exit;
}

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO user_post (user_id, post_content) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $post_text);

if ($stmt->execute()) {
    $response['username'] = get_username($user_id) || get_username_byToken($authorizationToken);
    $response['postText'] = $post_text;
    $response['success'] = true;
    echo json_encode($response);
} else {
    http_response_code(500); // Internal Server Error
    $response['error_message'] = "Failed to create post. Please try again later.";
    echo json_encode($response);
}

$stmt->close();

// Function to validate authorization token
function validateAuthorizationToken($token) {
    // Implement your validation logic here
    // Return true if the token is valid, false otherwise
    // Example: return $token === 'valid_token';
    return true;
}

// Function to get username by user_id
function get_username($user_id) {
    global $conn;
    $sql = "SELECT username FROM user_register WHERE user_id=$user_id";
    $sql_result = $conn->query($sql);
    $sql_row = $sql_result->fetch_assoc();
    return $sql_row['username'];
}

function get_username_byToken($authorizationToken) {
    global $conn;
    // Fix SQL query to handle string values
    $sql = "SELECT username FROM user_register WHERE authorization_token='$authorizationToken'";
    $sql_result = $conn->query($sql);
    $sql_row = $sql_result->fetch_assoc();
    return $sql_row['username'];
}
?>
