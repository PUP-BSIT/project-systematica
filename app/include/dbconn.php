<?php
$servername = "127.0.0.1:3306";
$username = "postify_db";  // Hostinger Username
$password = "8nNiCJ9rP[";      // Database Password
$database = "u722605549_postify";  // Hostinger Database Name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Close the connection when done
$conn->close();
?>