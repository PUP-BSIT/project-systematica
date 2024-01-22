<?php

//Hostinger Database
$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

//Localhost Database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "postify_db";


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
//$apiToken = "fed67c1e9057bb9a3d75fcff87096662";

// Output the API token in HTML
//echo "<p>Generated API Token: $apiToken</p>";

?>
