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

if(isset($_GET['redirect_url']) && isset($_GET['application_name'])){
    $redirectUrl = $_GET['redirect_url'] ?? '';
    $applicationName = $_GET['application_name'] ?? '';

    $cookie_name_email = 'email';
    if(isset($_COOKIE[$cookie_name_email])){
        $cookie_value = $_COOKIE[$cookie_name_email];

        // Debugging: Check if the cookie value is retrieved correctly
        echo "Cookie Value: " . $cookie_value;

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM user_register WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cookie_value);
        mysqli_stmt_execute($stmt);

        // Debugging: Check if the query is executed successfully
        if (!$stmt) {
            echo "Error executing query: " . mysqli_error($conn);
        }

        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $authorization_token = $row['authorization_token'];
                authorizeOnce($redirectUrl, $authorization_token);
            } else {
                echo "No rows found.";
                authorizeUser($redirectUrl, $applicationName);
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
    } else {
        authenticateUser($redirectUrl, $applicationName);
    }
}


function authenticateUser($redirectUrl, $applicationName){
    header("Location: postify-auth/login-postify.php?redirect_url=" . urlencode($redirectUrl) . "&application_name=" . urlencode($applicationName));
    exit();
}

function authorizeUser($redirectUrl, $applicationName){
    header("Location: postify-auth/authorization-page.php?redirect_url=" . urlencode($redirectUrl) . "&application_name=" . urlencode($applicationName));
    exit();
}

function authorizeOnce($redirectUrl, $authorization_token){
    header("Location: $redirectUrl?authorization_token=" . urlencode($authorization_token) . "&application_name=Postify");
    exit();
}

function get_token_api() {

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

// Simulate the API response for the get-token endpoint
function generateToken() {
    // Generate a random string as the authorization token
    $tokenLength = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $authorizationToken = substr(str_shuffle($characters), 0, $tokenLength);

    // You may want to add additional logic for uniqueness or other requirements
    return $authorizationToken;
}

?>
