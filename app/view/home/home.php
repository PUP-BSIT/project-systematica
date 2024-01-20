<?php
// homepage.php

$apiUrls = array(
    'https://hypehive.cloud/authorization/get-user.php?authorization_token=',
    'https://likha.website/get-user.php?authorization_token=',
    'https://postify.tech/get-user.php?authorization_token='
);

if (isset($_GET['authorization_token'])) {
    $authToken = $_GET['authorization_token'];

    if (!empty($authToken)) {
        // Start a session if not already started

        foreach ($apiUrls as $apiUrl) {
            $apiUrlWithToken = $apiUrl . urlencode($authToken);
            $response = file_get_contents($apiUrlWithToken);
            if (session_status() == PHP_SESSION_NONE) {
            session_start();
            }
            if ($response !== false) {
                $userData = json_decode($response, true);

                if ($userData !== null) {
                    // Store the user data in the session
                    $_SESSION['userData'][] = $userData;

                    // Print the user data
                    print_r($userData);
                } else {
                    echo "Failed to decode JSON response for API: $apiUrlWithToken.";
                }
            } else {
                echo "Failed to retrieve user data from API: $apiUrlWithToken. Check API URL or server configuration.";
            }
        }

        // Now $username contains the value of the 'username' key from the last API response
        echo "Username: " . $_SESSION['userData']['username'];
    } else {
        echo "Authorization token is empty.";
    }
} else {
    echo "Authorization token not provided in the URL.";
}
?>
