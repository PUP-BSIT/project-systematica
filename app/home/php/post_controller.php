<?php

session_Start();

$authorizationToken = $_SESSION['auth_token'];
$postContent = $POST_["post"];
$imageFile = $_FILED["fileInput"];

// Likha API endpoint
$apiUrl = "https://likha.webiste/create-post.php";

// Set the image daa for the API Request
$imageData = array('image' => new CURLFile($imageFile["tmp_name"], $imageFile["type"], $imageFile["name"]));

// Data for the Post Creation API Request

$data = array(
    'post-content' => $postContent,
    'authorization_token' => $authorizationToken,
);

// Append image data to the request
$data = array_merge($data, $imageData);
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session for post creation and get the response;

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($response !== null) {
    echo "Response Status Code: $status\n";
    echo "Response Body: $response\n";
} else {
    echo "Invalid JSON response from Likha Website";
}
?>