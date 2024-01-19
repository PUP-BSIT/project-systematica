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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize $userData outside the loop
        $userData = null;

        foreach ($apiUrls as $apiUrl) {
            $apiUrlWithToken = $apiUrl . urlencode($authToken);
            $response = file_get_contents($apiUrlWithToken);

            // Corrected variable name from $detailsArray to $response
            if ($response !== false) {
                $userData = json_decode($response, true);

                if ($userData !== null) {
                    // Store $userData in a session variable
                    $_SESSION['userData'] = $userData;

                    // Access the 'username' key from the 'userData' array
                    //$username = $userData['username'];

                    // Now $username contains the value of the 'username' key
                    // Display username and email
                    echo "Username: " . $userData[0]['username'] . "<br>";
                    echo "Email: " . $userData[0]['email'];
                } else {
                    echo "Failed to decode JSON response.";
                }

                // Break out of the loop once data is successfully retrieved
                break;
            } else {
                echo "Failed to retrieve user data. Check API URL or server configuration.";
            }
        }

        // Print the user data after the loop if needed
        if ($userData !== null) {
            //print_r($userData);
        }
    } else {
        echo "Authorization token is empty.";
    }
} else {
    echo "Authorization token not provided in the URL.";
}
?>
