<?php
// $redirectUrl = 'https://dev.postify.tech/app/view/home/homepage.html';
$redirectUrl = 'https://test.postify.tech/app/home/homepage.php';
$applicationName = 'Postify';

$apiUrl = 'https://postify.tech/postify-auth/login-postify.php?redirect_url=' . urlencode($redirectUrl) . '&application_name=' . urlencode($applicationName);

header('Location:' . $apiUrl);
exit();
?> 