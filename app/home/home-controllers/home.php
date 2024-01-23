<?php
// homepage.php

session_start();

// Database connection parameters for Hostinger
$servername = "127.0.0.1:3306";
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
    // echo "Connected successfully";  // Uncomment if needed

    // Function to get the database connection
    function getDBConnection() {
        global $servername, $username, $password, $database;

        $dbConnection = new mysqli($servername, $username, $password, $database);

        if ($dbConnection->connect_error) {
            die("Connection failed: " . $dbConnection->connect_error);
        }

        return $dbConnection;
    }

    function getUserData($apiName, $authToken, $dbConnection) {
        $apiUrl = '';
        echo $apiUrl;
        switch ($apiName) {
            case 'HypeHive':
                $apiUrl = 'https://hypehive.cloud/authorization/get-user.php?authorization_token=' . urlencode($authToken);
                break;
            case 'Likha':
                $apiUrl = 'https://likha.website/get-user.php?authorization_token=' . urlencode($authToken);
                break;
            case 'Postify':
                $apiUrl = 'https://postify.tech/get-user.php?authorization_token=' . urlencode($authToken);
                break;
            default:
                echo "Invalid API name.";
                return;
        }

        //echo "API URL: " . $apiUrl . "\n"; // Add this line to display the constructed API URL

        $response = file_get_contents($apiUrl);

        //echo $response;

        if ($response !== false) {
            $userData = json_decode($response, true);
            if ($userData !== null) {
                    saveUserDataToDatabase($userData, $authToken, $apiName, $dbConnection);
            } else {
                echo "Failed to decode JSON response for $apiName API.";
            }
        } else {
            echo "Failed to retrieve user data for $apiName API. Check API URL or server configuration.";
            // Display additional error information
            echo "Error: " . error_get_last()['message'];
        }
    }

    function saveUserDataToDatabase($userData, $authToken, $apiName, $dbConnection) {
        // Assuming you have a 'user_register' table with 9 columns
        $email = $userData[0]['email'];
        $username = $userData[0]['username'];
        $first_name = $userData[0]['first_name'];
        $middle_name = $userData[0]['middle_name'];
        $last_name = $userData[0]['last_name'];
        $birthdate = $userData[0]['birthday'];
        $applicationName = $apiName; // Add this line

        // Check if email exists in the database
        $existingRecord = getExistingRecordByEmail($email, $dbConnection);

        if ($existingRecord) {
            // Update existing record with new authorization token
            updateAuthorizationToken($email, $authToken, $dbConnection);
        } else {
            // Insert a new record
            insertNewRecord($email, $username, $first_name, $middle_name, $last_name, $birthdate, $authToken, $applicationName, $dbConnection);
        }
    }

    function getExistingRecordByEmail($email, $dbConnection) {
        $query = "SELECT * FROM user_register WHERE email = ?";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->fetch_assoc();
    }

    function updateAuthorizationToken($email, $authToken, $dbConnection) {
        $query = "UPDATE user_register SET authorization_token = ? WHERE email = ?";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('ss', $authToken, $email);

        if ($stmt->execute()) {
            //echo "Authorization token updated for existing user.";
            $sql = "SELECT * FROM user_register WHERE email = '$email'";
            $sql_result = $dbConnection->query($sql);
            $sql_row = $sql_result->fetch_assoc();
            $user_id = $sql_row['user_id'];
            var_dump($user_id);
            $_SESSION['user_id'] = $user_id;

        } else {
            echo "Failed to update authorization token. Error: " . $stmt->error;
        }

        $stmt->close();
    }

    function insertNewRecord($email, $username, $first_name, $middle_name, $last_name, $birthdate, $authToken, $applicationName, $dbConnection) {
        $query = "INSERT INTO user_register (email, username, first_name, middle_name, last_name, birthdate, authorization_token, application_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbConnection->prepare($query);
        $stmt->bind_param('ssssssss', $email, $username, $first_name, $middle_name, $last_name, $birthdate, $authToken, $applicationName);

        if ($stmt->execute()) {
            echo "New user data saved to the database.";
            $sql = "SELECT * FROM user_register WHERE email = '$email'";
            $sql_result = $dbConnection->query($sql);
            $sql_row = $sql_result->fetch_assoc();
            $user_id = $sql_row['user_id'];
            var_dump($user_id);
            $_SESSION['user_id'] = $user_id;
        } else {
            echo "Failed to save new user data. Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Create a database connection using the function
    $dbConnection = getDBConnection();

    if (isset($_GET['authorization_token'])) {
        $authToken = $_GET['authorization_token'];
    
        // Check if application_name is present in the URL
        if (isset($_GET['application_name'])) {
            $apiName = $_GET['application_name'];
        } else {
            echo "Application name is not provided in the URL.";
            // You may want to handle this case appropriately, e.g., exit or return an error response.
            exit;
        }
    
        if (!empty($authToken)) {
            // Test with Likha API
            getUserData($apiName, $authToken, $dbConnection);
        } else {
            echo "Authorization token is empty.";
        }
    } else {
        // echo "Authorization token not provided in the URL.";
        // You may want to handle this case appropriately, e.g., exit or return an error response.
    }    

    // Close the database connection
    $dbConnection->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
