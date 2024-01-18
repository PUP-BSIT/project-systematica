<?php
$redirectUrl = 'https://dev.postify.tech/app/view/home/home_page.html';
$applicationName = 'Postify';

$apiUrl = 'https://postify.tech/get-token.php?redirect_url=' . urlencode($redirectUrl) . '&application_name=' . urlencode($applicationName);

header('Location:' . $apiUrl);
exit();
?>