<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['likha-username'];
    $password = $_POST['likha-password'];

    // Send a request to the external system's API to authenticate the user
    // and obtain the authorization token. Replace the following lines with actual API call logic.
    $authorization_token = authenticateUser($username, $password);

    if ($authorization_token) {
        // Authentication successful, store the authorization token in a session or database
        session_start();
        $_SESSION['authorization_token'] = $authorization_token;

        // Redirect to a protected page or perform other actions
        header('Location: ../home/home_page.html');
        exit();
    } else {
        // Authentication failed, redirect back to the login page
        header('Location: login-likha.html');
        exit();
    }
}

// Function to authenticate the user with the external system
function authenticateUser($username, $password) {
    // API configuration
    $api_key = 'J7hP2fR1dVgQ9sX4tY0aL6mB3nZ8cO5';
    $api_url = 'https://likha.website';

    // Make an API request to authenticate the user and obtain the authorization token
    // Replace this with actual API call logic using cURL, Guzzle, or another library.
    // Example using cURL:
    $url = $api_url . '/authenticate'; // Adjust the endpoint accordingly
    $data = ['username' => $username, 'password' => $password, 'api_key' => $api_key];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);

    // Parse the API response and handle success or failure
    $api_response = json_decode($response, true);

    if (isset($api_response['authorization_token'])) {
        // Authentication successful
        return $api_response['authorization_token'];
    } else {
        // Authentication failed
        // Redirect with error message
        $error_message = urlencode(isset($api_response['error_message']) ? $api_response['error_message'] : 'Unknown error');
        header("Location: https://likha.website?error_message={$error_message}");
        exit();
    }
}
