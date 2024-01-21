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
    $field = $_POST['field'] ?? '';
    $value = $_POST['value'] ?? '';

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM user_register WHERE $field = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    // Send response to JavaScript
    echo json_encode(['exists' => $count > 0]);

    $stmt->close();
    $conn->close();
}
?>
