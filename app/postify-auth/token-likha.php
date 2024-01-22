<?php
$redirectUrl = 'https://postify.tech/app/home/homepage.php';
$applicationName = 'Postify';

$apiUrl = 'https://likha.website/get-token.php?redirect_url=' . urlencode($redirectUrl) . '&application_name=' . urlencode($applicationName);

header('Location:' . $apiUrl);
exit();
?>