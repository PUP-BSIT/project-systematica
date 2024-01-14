<?php
// socmedAuth.php

function isValidApplicationName($appName) {
    // Add your custom validation logic for application_name
    // For example, check if it contains only alphanumeric characters
    return preg_match('/^[a-zA-Z0-9]+$/', $appName) === 1;
}

function isValidRedirectUrl($redirectUrl) {
    // Add your custom validation logic for redirect_url
    // For example, check if it is a valid URL
    return filter_var($redirectUrl, FILTER_VALIDATE_URL) !== false;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the raw POST data
    $postData = file_get_contents('php://input');

    // Decode JSON data
    $requestData = json_decode($postData, true);

    // Check if the required parameters are present
    if (
        !isset($requestData['redirect_url']) ||
        !isset($requestData['application_name']) ||
        empty($requestData['redirect_url']) ||
        empty($requestData['application_name']) ||
        !isValidRedirectUrl($requestData['redirect_url']) ||
        !isValidApplicationName($requestData['application_name'])
    ) {
        // Return an error response if parameters are missing or invalid
        $response = [
            'error' => 'Invalid or missing parameters',
        ];
        echo json_encode($response);
        http_response_code(400); // Bad Request
        exit;
    }

    // Your authentication logic goes here
    // You may want to validate the application_name, redirect_url, and generate an authorization token

    // For demonstration purposes, let's generate a simple authorization token
    $authorizationToken = md5(uniqid());

    // Prepare the response
    $response = [
        'authorization_token' => $authorizationToken,
        'redirect_url' => $requestData['redirect_url'],
    ];

    // Send the JSON response
    echo json_encode($response);

    // Connect to get-token.php and simulate a GET request
    $getTokenUrl = 'http://postify.tech/get-token.php';
    $getTokenUrl .= '?redirect_url=' . urlencode($requestData['redirect_url']);
    $getTokenUrl .= '&application_name=' . urlencode($requestData['application_name']);

    // Simulate a GET request to get-token.php
    $getTokenResponse = file_get_contents($getTokenUrl);

    // You can process $getTokenResponse if needed
} else {
    // Return an error response if the request method is not POST
    $response = [
        'error' => 'Invalid request method',
    ];
    echo json_encode($response);
    http_response_code(405); // Method Not Allowed
    exit;
}
?>
