<?php
session_start();

// Hostinger Database
$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

// Localhost Database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "postify_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$authToken = 'aSkb9FrHKEtGluUvxJ5NgM0zi4fe6WnQ';

$sql = "SELECT * FROM user_register WHERE email = ? OR authorization_token = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $authToken);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo "User ID: " . $row['user_id'] . "<br>";
    echo "First Name: " . $row['first_name'] . "<br>";
    echo "First Name: " . $row['middle_name'] . "<br>";
    echo "Last Name: " . $row['last_name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Created At: " . $row['created_at'] . "<br>";
} else {
    echo "No records found for the given email.";
}

// Close the database connection
$conn->close();
?>
