<?php
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

// Check if the token exists in the session
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    
    $userDetails = getUserDetailsByToken($token);

    if ($userDetails) {
        // Return user details as JSON response
        echo json_encode($userDetails);
    } else {
        // If user details are not found, return an error response
        echo json_encode(['error' => 'User details not found']);
    }
} else {
    // If the token is not set in the session, return an error response
    echo json_encode(['error' => 'Token not found in session']);
}

// Sample function to fetch user details based on the token (replace with your actual logic)
function getUserDetailsByToken($token) {
    
    $query = "SELECT users.*, tokens.token FROM users
              JOIN tokens ON users.user_id = tokens.user_id
              WHERE tokens.token = :token";
    // ... (execute query and fetch user details)
    // Return user details as an associative array
    // return $userDetails;
    return ['user_id' => 1, 'username' => 'sample_user', 'email' => 'sample@example.com', 'token' => 'your_token'];
}

?>
