<?php
// homepage.php

$apiUrls = array(
    'https://hypehive.cloud/authorization/get-user.php?authorization_token=',
    'https://likha.website/get-user.php?authorization_token=',
    'https://postify.tech/get-user.php?authorization_token='
);

echo $_GET;
if (isset($_GET['authorization_token'])) {
    $appName = $_GET['application_name'];
    

}
