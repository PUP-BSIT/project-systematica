<?php 

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

// Simulate the API response for the get-token endpoint
function generateToken() {
    // Generate a random string as the authorization token
    $tokenLength = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $authorizationToken = substr(str_shuffle($characters), 0, $tokenLength);

    // You may want to add additional logic for uniqueness or other requirements
    return $authorizationToken;
}

function authenticateUser(){
    header('Location: login-auth.php');
    exit();
}

authenticateUser();

function get_token_api() {
    $redirectUrl = $_GET['redirect_url'] ?? '';
    $applicationName = $_GET['application_name'] ?? '';


    // Check if the required parameters are present
    if (empty($redirectUrl) || empty($applicationName)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters']);
        exit();
    }  

    // Generate a more realistic authorization token
    $authorizationToken = generateToken();
    // Construct the redirect URL with the authorization token
    $redirectUrl .= '?authorization_token=' . $authorizationToken;
    // Redirect the user back to the specified redirect URL
    header('Location: ' . $redirectUrl);
    exit();
    
}
?>