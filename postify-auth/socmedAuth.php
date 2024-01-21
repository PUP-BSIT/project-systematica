<?php
// socmedAuth.php
session_start(); // Make sure to start the session

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isValidApplicationName($appName) {
    return preg_match('/^[a-zA-Z0-9]+$/', $appName) === 1;
}

function isValidRedirectUrl($redirectUrl) {
    return filter_var($redirectUrl, FILTER_VALIDATE_URL) !== false;
}

function generateToken() {
    $tokenLength = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $tokenLength);
}

function get_token_api($redirectUrl, $applicationName, $email, $conn) {
    // Check if the required parameters are present
    if (empty($redirectUrl) || empty($applicationName) || empty($email)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters']);
        exit();
    }

    // Generate authorization token
    $authorizationToken = generateToken();

    // Use prepared statement to prevent SQL injection
    $selectSql = "SELECT authorization_token FROM user_register WHERE email = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("s", $email);
    $selectStmt->execute();
    $selectStmt->store_result();

    // Check if the email already exists in the database
    if ($selectStmt->num_rows > 0) {
        // Email exists, update the existing record with the new authorization token
        $updateSql = "UPDATE user_register SET authorization_token = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $authorizationToken, $email);
        $updateStmt->execute();
    } else {
        // Email doesn't exist, insert a new record
        $insertSql = "INSERT INTO user_register (authorization_token, email) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ss", $authorizationToken, $email);
        $insertStmt->execute();
    }

    // Prepare the response
    $response = [
        'authorization_token' => $authorizationToken,
        'redirect_url' => $redirectUrl,
        'application_name' => 'Postify',
    ];

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    $selectStmt->close();
    if (isset($updateStmt)) {
        $updateStmt->close();
    }
    if (isset($insertStmt)) {
        $insertStmt->close();
    }

    $conn->close();
}



// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $redirectUrl = $data['redirect_url'];
    $applicationName = $data['application_name'];

    // Make sure the email is set in the session
    if (!isset($_SESSION['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Email not set in session']);
        exit;
    }

    $email = $_SESSION['email'];
    
    if (!isset($redirectUrl) || !isset($applicationName)) {
        // Return an error response if parameters are missing or invalid
        $response = [
            'error' => 'Invalid or missing parameters',
        ];
        echo json_encode($response);
        http_response_code(400); // Bad Request
        exit;
    }

    get_token_api($redirectUrl, $applicationName, $email, $conn);
    // Your authentication logic goes here
    // You may want to validate the application_name, redirect_url, and generate an authorization token
    // For demonstration purposes, let's generate a simple authorization token
} else {
    // Return an error response if the request method is not POST
    $response = [
        'error' => 'Invalid request method',
    ];
    echo json_encode($response);
}
?>
