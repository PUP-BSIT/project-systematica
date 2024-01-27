<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postContent = isset($_POST['post-content']) ? $_POST['post-content'] : '';
$auth_token = isset($_POST['authorization_token']) ? $_POST['authorization_token'] : '';

// Debugging: Print received data
echo "Received data: post-content=$postContent, authorization_token=$auth_token<br>";

$query = "SELECT user_id FROM user_register WHERE authorization_token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $auth_token);

if (!$stmt->execute()) {
    // Debugging: Print the error message
    echo "Error executing select query: " . $stmt->error . "<br>";

    $response = ['error' => "Error executing query: " . $stmt->error];
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $userId = $data['user_id'];

        // Debugging: Print user_id
        echo "User ID: $userId<br>";
        
        // Use the original $stmt variable for the SELECT query
        $stmt->close();

        $sql = "INSERT INTO user_post (user_id, post_content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $postContent);

        if (!$stmt->execute()) {
            // Debugging: Print the error message
            echo "Error executing insert query: " . $stmt->error . "<br>";

            $response = ['error' => "Error inserting post: " . $stmt->error];
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = ['success' => "Post inserted successfully!",
                         'user_id' => $userId,
                         'post_content' => $postContent];
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        $stmt->close();
    } else {
        // Debugging: Print the error message
        echo "User not found<br>";

        $response = ['error' => "User not found",
                     'authentication_token' => $auth_token];
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

$conn->close();
?>
