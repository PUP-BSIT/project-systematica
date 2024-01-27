<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hostinger Database
$servername = "127.0.0.1";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";

} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $firstName = $_POST['first-name'];
    $middleName = $_POST['middle-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'] ;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $birthdate = $_POST['birthdate'];
    

    // Check if the email already exists
    $checkEmailSql = "SELECT * FROM user_register WHERE email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $result = $checkEmailStmt->get_result();
    $row = $result->fetch_assoc();
    var_dump($row);
    // $emailCount = $row['count'];

    // $checkEmailStmt->close();

    // if ($emailCount > 0) {
    //     // Display an error message as the email already exists
    //     echo "Error: Email already exists.";
    // } else {
        // Insert the record into the database
        $insertSql = "INSERT INTO user_register (username, email, password_hash, first_name, middle_name, last_name, birthdate, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())";

        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sssssss", $username, $email, $password, $firstName, $middleName, $lastName, $birthdate);

        if ($insertStmt->execute()) {
            echo "Record inserted successfully";
            header("Location: ../view/thank-you.html");
        } else {
            echo "Error: " . $insertStmt->error;
        }

        $insertStmt->close();
    // }

    $conn->close();
}
?>
>
