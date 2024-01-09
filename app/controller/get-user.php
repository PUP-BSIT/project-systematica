<?php
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

try {
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
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}

// Sample function to fetch user details based on the token (replace with your actual logic)
function getUserDetailsByToken($token) {
    global $pdo; // Assuming $pdo is your database connection object

    $query = "SELECT user_profile_test.*, tokens.token 
              FROM user_profile_test
              JOIN tokens ON user_profile_test.user_id = tokens.user_id
              WHERE tokens.token = :token";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the statement
    $stmt->closeCursor();

    return $userDetails;
}
?>
