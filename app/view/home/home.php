<?php
// home.php
if (isset($GET['authorization_token'])){
    $authToken = $_GET['authorization_token'];

    $apiUrl = 'https://postify.tech/get-user.php?authorization_token=' . urlencode($authToken);
    $response = file_get_contents($apiUrl);
    if ($response !== false){
        $userData = json_decode($response, true);
        if ($userData !== null){
            print_r($userData);
        } else {
            echo "Failed to decode JSON response.";
        }
    } else {
        echo "Failed to retrieve user data.";
    }
}
?>