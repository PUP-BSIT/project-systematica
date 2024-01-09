<?php
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

// Replace 'fed67c1e9057bb9a3d75fcff87096662' with your actual token
$token = "fed67c1e9057bb9a3d75fcff87096662";

// Set the token in the session
$_SESSION['token'] = $token;

// Return the token as JSON response
echo json_encode(['token' => $token]);
?>
