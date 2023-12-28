<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../include/dbconn.php";  // Include the database connection file
    if (isset($_POST['uname']) && isset($_POST['password'])) {
        
        $password = $_POST['password'];
    }

    // Retrieve user input
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Validate user credentials
    $sql = "SELECT * FROM login WHERE user_name = '$input_username' AND user_password = '$input_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User is authenticated, you can redirect or set session variables here
        echo "Login successful!";
    } else {
        // Invalid credentials
        echo "Invalid username or password";
    }

    // Close the connection
    $conn->close();
}
?>
