<?php
session_start();
include "../../db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $firstName = $_POST['first-name'];
    $middleName = $_POST['middle-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $birthdate = $_POST['birthdate'];
    $selectedGender = $_POST['gender'];

    // Check if the email already exists
    $checkEmailSql = "SELECT COUNT(*) as count FROM user_register WHERE email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $result = $checkEmailStmt->get_result();
    $row = $result->fetch_assoc();
    $emailCount = $row['count'];

    $checkEmailStmt->close();

    if ($emailCount > 0) {
        // Display an error message as the email already exists
        echo "Error: Email already exists.";
    } else {
        // Insert the record into the database
        $insertSql = "INSERT INTO user_register (username, email, password_hash, first_name, last_name, birthdate, gender, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())";

        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sssssss", $username, $email, $password, $firstName, $lastName, $birthdate, $selectedGender);

        if ($insertStmt->execute()) {
            echo "Record inserted successfully";
            header("Location: ../view/thank-you.html");
        } else {
            echo "Error: " . $insertStmt->error;
        }

        $insertStmt->close();
    }

    $conn->close();
}
?>
