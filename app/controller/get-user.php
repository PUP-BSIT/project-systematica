<?php
include 'api.php';
include('../../include/db_conn.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

if (isset($_GET['authorization_token'])){
    $authToken = $_GET['authorization_token'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT user_name, first_name, middle_name, last_name, email, birthday FROM your_table_name WHERE authorization_token = ?";
    
    // Using MySQL for Database Interactions
    $stmt = $conn->prepare($query);

    // Bind the Parameters
    $stmt->bind_param('s', $authToken);

    // Execute the Query
    $stmt->execute();
    
    // Get the Result
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        header('Content-Type: application/json'); // Corrected typo in "application"
        echo json_encode($result->fetch_assoc()); // Using fetch_assoc() instead of fetch_all()
    } else {
        http_response_code(401); // Set HTTP response code to 401 for unauthorized
        echo json_encode(array('error_message' => 'Unsuccessful Authorization!'));
    }

    $stmt->close();

    $conn->close();
} else {
    echo "Auth not found in the URL";
}
?>
