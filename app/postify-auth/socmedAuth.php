<?php
// socmedAuth.php

function isValidApplicationName($appName) {
    return preg_match('/^[a-zA-Z0-9]+$/', $appName) === 1;
}

function isValidRedirectUrl($redirectUrl) {
    return filter_var($redirectUrl, FILTER_VALIDATE_URL) !== false;
}

function generateToken() {
    $tokenLength = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $tokenLength);
}

function get_token_api($redirectUrl, $applicationName) {
    // Check if the required parameters are present
    if (empty($redirectUrl) || empty($applicationName)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters']);
        exit();
    }
    
    $authorizationToken = generateToken();
    
    // Prepare the response
    $response = [
        'authorization_token' => $authorizationToken,
        'redirect_url' => $redirectUrl,
    ];

    header('Content-Type: application/json');
    // Send the JSON response
    echo json_encode($response);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $redirectUrl = $data['redirect_url'];
    $applicationName = $data['application_name'];
    
    if (empty($redirectUrl) || empty($applicationName)) {
        // Return an error response if parameters are missing or invalid
        $response = [
            'error' => 'Invalid or missing parameters',
        ];
        echo json_encode($response);
        http_response_code(400); // Bad Request
        exit;
    }
    get_token_api($redirectUrl, $applicationName);
    // Your authentication logic goes here
    // You may want to validate the application_name, redirect_url, and generate an authorization token
    // For demonstration purposes, let's generate a simple authorization token
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
