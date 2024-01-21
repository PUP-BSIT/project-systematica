<?php
$redirectUrl = 'https://postify.tech/';
$applicationName = 'Postify';

$apiUrl = 'https://hypehive.cloud/authorization/get-token.php?redirect_url=' . urlencode($redirectUrl) . '&application_name=' . urlencode($applicationName);

header('Location:' . $apiUrl);
exit();
?> 