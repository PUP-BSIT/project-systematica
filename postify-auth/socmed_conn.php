<?php
session_start();
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

// Retrieve the POST data
$requestData = json_decode(file_get_contents("php://input"), true);

$email = $requestData['email'];
$password = $requestData['password'];

$_SESSION['email'] = $email;
$sql = "SELECT * FROM user_register WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $hashed_password = $user['password_hash'];

    // Use password_verify to check if the entered password matches the hashed password
    if (password_verify($password, $hashed_password)) {
        // Password is correct
        // Prepare the response
        $response = [
            'status' => 'Login Successful',
            'redirect_url' => $requestData['redirect_url'],
            'application_name' => $requestData['application_name'],
        ];
    } else {
        // Invalid password
        $response = ['status' => 'Login Failed', 'error' => 'Invalid email or password'];
    }
} else {
    // User not found
    $response = ['status' => 'Login Failed', 'error' => 'Invalid email or password'];
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
