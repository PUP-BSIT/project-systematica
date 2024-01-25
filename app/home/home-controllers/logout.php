<?php 
session_start();

$cookie_name_email = "email";
setcookie($cookie_name_email, "", time() - 3600, "/");

session_unset();
session_destroy();

header("Location: ../../login.html");
?>
