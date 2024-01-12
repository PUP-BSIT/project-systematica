<?php
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

// API endpoint for getting a token
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get-token') {
    include('get-token.php');
    exit;
}

// API endpoint for getting user details
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get-user') {
    include('get-user.php');
    exit;
}
?>
