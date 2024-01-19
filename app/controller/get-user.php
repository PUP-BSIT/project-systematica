<?php
// get-user.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['authorization_token'])) {
    // Get the auth_token from the URL
    $authToken = $_GET['authorization_token'];

    // Query to validate token in the users table
    $query = "SELECT user_name FROM user_register WHERE authorization_token = '$authToken'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $authToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, retrieve additional details from user_details table
        $userRow = $result->fetch_assoc();
        $userName = $userRow['user_name'];

        // Query to get user details from user_details table using user_name
        $detailsQuery = "SELECT first_name, middle_name, last_name, email, birthday FROM user_details WHERE user_name = '$userName'";
        $detailsStmt = $conn->prepare($detailsQuery);
        $detailsStmt->bind_param('s', $userName);
        $detailsStmt->execute();
        $detailsResult = $detailsStmt->get_result();

        if ($detailsResult->num_rows > 0) {
            // Fetch user details
            $userDetails = $detailsResult->fetch_assoc();

            // Create the response array in the desired format
            $response = [
                'username' => $userName,
                'first_name' => $userDetails['first_name'],
                'middle_name' => $userDetails['middle_name'],
                'last_name' => $userDetails['last_name'],
                'email' => $userDetails['email'],
                'birthday' => $userDetails['birthday'],
            ];

            // Return user details as JSON
            echo json_encode($response);
        } else {
            // No details found in user_details table
            echo json_encode(['error_message' => 'User details not found.']);
        }

        // Close the details statement
        $detailsStmt->close();
    } else {
        http_response_code(401); // Set HTTP response code to 401 for unauthorized
        echo json_encode(['error_message' => 'Unsuccessful Authorization!']);
    }
} else {
    // If authorization token is not found
    http_response_code(400); // Set HTTP response code to 400 for bad request
    echo json_encode(['error_message' => 'Authorization token not found in the URL.']);
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>
