<?php
include 'api.php';
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


session_start();

function get_user_data($token) {
    if (isset($_SESSION['authorization_token']) && $_SESSION['authorization_token'] === $token) {
        $user_data = array(
            "username" => "johndee",
            "first_name" => "John",
            "middle_name" => "Dee",
            "last_name" => "Cruz",
            "email" => "john_cruz@sample.com",
            "birthday" => "12/01/1997",
        );

        return json_encode($user_data);
    } else {
        header("HTTP/1.1 401 Unauthorized");
        return "Unsuccessful Authorization!";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'get-user-data') {
    $token = $_GET['token'] ?? '';
    $user_data_response = get_user_data($token);
    echo $user_data_response;
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid action']);
}

?>

