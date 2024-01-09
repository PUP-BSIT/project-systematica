<?php

$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "postify_db";

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
?>

<?php


// Example usage
$apiToken = "fed67c1e9057bb9a3d75fcff87096662";

// Output the API token in HTML
//echo "<p>Generated API Token: $apiToken</p>";
?>
