<?php
require "../../../db_conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Authorization token not required or valid, proceed with post creation

$user_id = $_SESSION['user_id'];

$shareLikhaPost = isset($_POST['shareToLikha']) ? $_POST['shareToLikha'] : '';
$shareHypehivePost = isset($_POST['shareToHypehive']) ? $_POST['shareToHypehive'] : '';
$post_text = isset($_POST['post_text']) ? $_POST['post_text'] : '';

// var_dump("Likha: " . $shareLikhaPost);
// var_dump("Hypehive: " . $shareHypehivePost);

if($shareLikhaPost == 'null' && $shareHypehivePost == 'null'){
    // var_dump('NULL BOTH');
    postifyPost($conn,$user_id,$post_text);
} else if($shareLikhaPost == 'Likha' && $shareHypehivePost == 'null'){
    // var_dump('SHARE TO LIKHA');   
    shareLikha();
    postifyPost($conn,$user_id,$post_text);
} else if($shareHypehivePost == 'Hypehive' && $shareLikhaPost == 'null'){
    // var_dump('SHARE TO HYPEHIVE');
    shareHypehive();
    postifyPost($conn,$user_id,$post_text);
}

// var_dump($sharePost);
function postifyPost($conn,$user_id,$post_text){
// Check if 'post_image' is set in $_FILES
if (isset($_FILES['post_image'])) {
    $imageFile = $_FILES['post_image'];
    $fileName = $imageFile['name'];

    // Use prepareds statement to prevent SQL injection
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
            $stmt2->bind_param("iss", $user_id, $post_id, $fileName);

            if ($stmt2->execute()) {
                $response['username'] = get_username($user_id);
                $response['postText'] = $post_text;
                // $response['sharePost'] = $sharePost;
                $response['imagePath'] = get_image_path($post_id);
                $response['success'] = true;
                echo json_encode($response);

                // Debug statements
                echo "Image uploaded successfully. Path: " . get_image_path($post_id);
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
} else {
    // No image uploaded, proceed with text-only post
    $stmt = $conn->prepare("INSERT INTO user_post (user_id, post_content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $post_text);

    if ($stmt->execute()) {
        $response['username'] = get_username($user_id);
        $response['postText'] = $post_text;
        //  $response['sharePost'] = $sharePost;
        $response['success'] = true;
        echo json_encode($response);
    } else {
        http_response_code(500); // Internal Server Error
        $response['error_message'] = "Failed to create text-only post. Please try again later.";
        echo json_encode($response);

        // Debug statements
        echo "Failed to create text-only post. Please try again later.";
    }

    $stmt->close();
}
}

function shareLikha(){
    $authorizationToken = $_SESSION['authorization_token'];
    // var_dump($authorizationToken);
    $postContent = $_POST["post_text"];
    $imageFile = $_FILES["post_image"];
    // var_dump($imageFile);
    // Likha API endpoint
    //$apiUrl = "https://likha.website/create-post.php";
    $apiUrl = "https://likha.iletupass.online/create-post.php";

    // Set the image daa for the API Request
    $imageData = array('image' => new CURLFile($imageFile["tmp_name"], $imageFile["type"], $imageFile["name"]));

    // Data for the Post Creation API Request

    $data = array(
        'post-content' => $postContent,
        'authorization_token' => $authorizationToken,
    );

    // Append image data to the request
    $data = array_merge($data, $imageData);
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session for post creation and get the response;

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response !== null) {
        echo  $status;
        echo  $response;
    } else {
        echo "Invalid JSON response from Likha Website";
    }
}

function shareHypehive(){
    $authorizationToken = $_SESSION['authorization_token'];
    $postContent = $_POST["post_text"];
    // Hypehive API endpoint
    $apiUrl = "https://hypehive.cloud/api/createPost.php";
    
    // Data for the Post Creation API Request
    $data = array(
        'post-content' => $postContent,
        'authorization_token' => $authorizationToken,
    );

    // Append image data to the request
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session for post creation and get the response;

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response !== null) {
        echo  $status;
        echo  $response;
    } else {
        echo "Invalid JSON response from Hypehive Website";
    }
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