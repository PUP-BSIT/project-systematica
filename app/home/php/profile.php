<?php
require "../../../db_conn.php";

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    echo get_username($user_id);
} else {
    echo 'User not logged in.';
}

function get_username($user_id) {
    global $servername, $username, $password, $database;

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT username FROM user_register WHERE user_id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);

    if (!$stmt->execute()) {
        throw new Exception("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        // No rows found, handle the situation accordingly
        $username = "User not found";
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    return $username;
}
?>
