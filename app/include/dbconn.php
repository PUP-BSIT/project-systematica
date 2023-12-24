<?php
$servername = "127.0.0.1";
$username = "root";  // local database
$password = "";      // leave it blank
$database = "postify";  // the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
