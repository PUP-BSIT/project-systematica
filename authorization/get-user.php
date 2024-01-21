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
    $authToken = $_GET['authorization_token'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT username FROM user_register WHERE authorization_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $authToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userRow = $result->fetch_assoc();
        $userName = $userRow['username'];

        $detailsQuery = "SELECT first_name, middle_name, last_name, email, birthdate FROM user_register WHERE username = ?";
        $detailsStmt = $conn->prepare($detailsQuery);
        $detailsStmt->bind_param('s', $userName);
        $detailsStmt->execute();
        $detailsResult = $detailsStmt->get_result();

        if ($detailsResult->num_rows > 0) {
            $userDetails = $detailsResult->fetch_assoc();
            $response = [
                'username' => $userName,
                'first_name' => $userDetails['first_name'],
                'last_name' => $userDetails['last_name'],
                'middle_name' => $userDetails['middle_name'],
                'email' => $userDetails['email'],
                'birthday' => $userDetails['birthdate'],
                'application_name' => 'Postify'
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error_message' => 'User details not found.']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['error_message' => 'Unsuccessful Authorization!']);
    }
} else {
    http_response_code(400);
    //echo json_encode(['error_message' => 'Authorization token not found in the URL.']);
}

$stmt->close();
$conn->close();
?>
