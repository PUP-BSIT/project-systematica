<?php
require "../../../db_conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Authorization token not required or valid, proceed with post creation
$user_id = $_SESSION['user_id'];
$imageFile = $_FILES['post_image'];
$fileName = $imageFile['name'];  // Uncomment this line

var_dump($imageFile);

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
$stmt ->bind_param("is", $user_id, $post_text);

if ($stmt->execute()) {
    $post_id = $stmt->insert_id;

    $stmt2 = $conn->prepare("INSERT INTO image_table (user_id, post_id, image_path, upload_date) VALUES (?, ?, ?, NOW())");
    $stmt2->bind_param("iss", $user_id, $post_id, $fileName);  // Updated bind_param
    if($stmt2->execute()){
        $response['username'] = get_username($user_id);
        $response['postText'] = $post_text;

        $response['success'] = true;
        echo json_encode($response);
    } else {
        http_response_code(500); // Internal Server Error
        $response['error_message'] = "Failed to insert image record: " . $stmt2->error;
        echo json_encode($response);
    }
} else {
    http_response_code(500); // Internal Server Error
    $response['error_message'] = "Failed to create post. Please try again later.";
    echo json_encode($response);
}

$stmt->close();
$stmt2->close();

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
?>
