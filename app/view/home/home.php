<?php
// homepage.php

$apiUrls = array(
    'https://hypehive.cloud/authorization/get-user.php?authorization_token=',
    'https://likha.website/get-user.php?authorization_token=',
    'https://postify.tech/get-user.php?authorization_token='
);

if (isset($_GET['authorization_token'])) {
    $authToken = $_GET['authorization_token'];
    var_dump($authToken);
    if (!empty($authToken)) {
        // Start a session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        foreach ($apiUrls as $apiUrl) {
            $apiUrlWithToken = $apiUrl . urlencode($authToken);
            $response = file_get_contents($apiUrlWithToken);

            if ($response !== false) {
                $userData = json_decode($response, true);

                if ($userData !== null) {
                    // Check if expected keys exist before accessing them
                    if (isset($userData['username'])) {
                        // Store the user data in the session
                        $_SESSION['userData'][] = $userData;

                        // Print the user data
                        echo "API Response for $apiUrlWithToken:<br>";
                        foreach ($userData as $key => $value) {
                            echo "$key: $value<br>";
                        }

                        // Access 'username' key from the last API response
                        $lastUserDataIndex = count($_SESSION['userData']) - 1;

                        if (isset($_SESSION['userData'][$lastUserDataIndex]['username'])) {
                            $username = $_SESSION['userData'][$lastUserDataIndex]['username'];
                            echo "Username: " . $username;
                        } else {
                            echo "Username not found in the last API response.";
                        }

                        // Access other keys similarly
                        if (isset($_SESSION['userData'][$lastUserDataIndex]['first_name'])) {
                            $firstName = $_SESSION['userData'][$lastUserDataIndex]['first_name'];
                            echo "<br>First Name: " . $firstName;
                        } else {
                            echo "<br>First Name not found in the last API response.";
                        }

                        // Repeat the process for other keys like 'last_name', etc.
                        echo "<hr>"; // Add a horizontal line for better separation
                    } else {
                        echo "Username key not found in the API response: $apiUrlWithToken";
                    }
                } else {
                    echo "Failed to decode JSON response for API: $apiUrlWithToken.";
                }
            } else {
                echo "Failed to retrieve user data from API: $apiUrlWithToken. Check API URL or server configuration.";
            }
        }
    } else {
        echo "Authorization token is empty.";
    }
} else {
    echo "Authorization token not provided in the URL.";
}
?>
