<?php
session_start();
include "../../include/db_conn.php";

if (isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM user_profile_test WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    // Destroy the session
    session_unset();
    session_destroy();

    // Send a response to the client
    echo 'Logout successful';
} else {
    // If the user is not logged in, send an error response
    header('HTTP/1.1 401 Unauthorized');
    echo 'User not logged in';
}
?>
