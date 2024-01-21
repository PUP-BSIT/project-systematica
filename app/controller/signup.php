<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hostinger Database
// $servername = "127.0.0.1";
// $username = "u722605549_admin";
// $password = "VUbu4Zhkp7=o";
// $database = "u722605549_postify_db";

// Localhost Database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "postify_db";

try {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $firstName = $_POST['first-name'] ?? '';
    $middleName = isset($_POST['middle-name']) ? $_POST['middle-name'] : '';
    $lastName = $_POST['last-name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $birthdate = $_POST['birthdate'] ?? '';

    try {
        $insertSql = "INSERT INTO user_register (username, email, password_hash, first_name, middle_name, last_name, birthdate, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())";

        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sssssss", $username, $email, $password, $firstName, $middleName, $lastName, $birthdate);

        if ($insertStmt->execute()) {
            echo json_encode(array("success" => "Record inserted successfully"));
        } else {
            throw new Exception("Error: " . $insertStmt->error);
        }

        $insertStmt->close();
    } catch (mysqli_sql_exception $ex) {
        // Check if it's a duplicate entry error
        if ($ex->getCode() == 1062) {
            // Send a JSON response indicating that the username or email already exists
            echo json_encode(array("error" => "Username or email already exists"));
        } else {
            // Send a JSON response with the generic error message
            echo json_encode(array("error" => "Error: " . $ex->getMessage()));
        }
    }

    $conn->close();
}
?>