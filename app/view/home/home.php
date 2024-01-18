<?php
if (isset($GET['authorizationToken'])){
    $authToken = $_GET['authorization_token'];

    $apiUrl = 'https://postify.tech/get-user.php?authoriztion_token' . urlencode($authToken);
    $response = file_get_contents($apiUrl);
    if ($response !== false){
        $userData = json_decode($response, true);
        if ($userData !== null){
            print_r($userData);
        } else {
            echo "ailed to decode JSON response.";
        }
    } else {
        echo "Failed to retrieve user data.";
    }
}
?>