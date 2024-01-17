<?php
include 'api.php';

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://likha.website, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_GET['authorization_token'])) {
    $authToken = $_GET['authorization_token'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT user_name, first_name, middle_name, last_name, email, birthday FROM user_profile_test WHERE auth_token = $authToken";

    // Using MySQLi for Database Interactions
    $stmt = $conn->prepare($query);

    // Check if the statement preparation was successful
    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    // Bind the Parameters
    $stmt->bind_param('s', $authToken);

    // Execute the Query
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->error) {
        die('Error in executing the statement: ' . $stmt->error);
    }

    // Get the Result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the result as an associative array
        $row = $result->fetch_assoc();

        // Prepare the JSON response
        $response = array(
            'username' => $row['user_name'],
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'birthday' => $row['birthday']
        );

        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(401); // Set HTTP response code to 401 for unauthorized
        echo json_encode(array('error_message' => 'Unsuccessful Authorization!'));
    }

    // Close the statement
    $stmt->close();
} else {
    http_response_code(400); // Set HTTP response code to 400 for bad request
    echo json_encode(array('error_message' => 'Authorization token not found in the URL.'));
}

// Close the database connection
$conn->close();
?>
