<?php
require "../../../db_conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Authorization token not required or valid, proceed with post creation
$user_id = $_SESSION['user_id'];
$imageFile = $_FILES['post_image'];
$fileName = $imageFile['name'];

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
    $post_id = $stmt->insert_id;

    // Validate if the uploaded file is an image
    $image_info = getimagesize($imageFile['tmp_name']);
    if (!$image_info) {
        http_response_code(400); // Bad Request
        $response['error_message'] = "Uploaded file is not a valid image.";
        echo json_encode($response);
        exit;
    }

    // Limitations on image size and type
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size = 5 * 1024 * 1024; // 5 MB

    if (!in_array($image_info['mime'], $allowed_types) || $imageFile['size'] > $max_size) {
        http_response_code(400); // Bad Request
        $response['error_message'] = "Invalid image type or size exceeded.";
        echo json_encode($response);
        exit;
    }

    // Move the uploaded file to a suitable location
    $uploadDirectory = '../../assets/uploads/';
    $uploadPath = $uploadDirectory . $fileName;

    if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
        $stmt2 = $conn->prepare("INSERT INTO image_table (user_id, post_id, image_path, upload_date) VALUES (?, ?, ?, NOW())");
        $stmt2->bind_param("iss", $user_id, $post_id, $uploadPath);

        if ($stmt2->execute()) {
            $response['username'] = get_username($user_id);
            $response['postText'] = $post_text;
            $response['imagePath'] = get_image_path($postId);
            echo $response;
            $response['success'] = true;
            echo json_encode($response);

            // Debug statements
            echo "Image uploaded successfully. Path: " . $uploadPath;
        } else {
            http_response_code(500); // Internal Server Error
            $response['error_message'] = "Failed to insert image record: " . $stmt2->error;
            echo json_encode($response);

            // Debug statements
            echo "Failed to insert image record: " . $stmt2->error;
        }
    } else {
        http_response_code(500); // Internal Server Error
        $response['error_message'] = "Failed to move uploaded file.";
        echo json_encode($response);

        // Debug statements
        echo "Failed to move uploaded file.";
    }
} else {
    http_response_code(500); // Internal Server Error
    $response['error_message'] = "Failed to create post. Please try again later.";
    echo json_encode($response);

    // Debug statements
    echo "Failed to create post. Please try again later.";
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
    $stmt = $conn->prepare("SELECT username FROM user_register WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
    return $username;
}

function get_image_path($postId){
    global $conn;
    $stmt = $conn->prepare("SELECT image_path FROM image_table WHERE post_id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();
    return $imagePath;
}
?>
