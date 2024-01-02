<?php
session_start();
include "../../include/db_conn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $input_username = validate($_POST['username']);
    $input_password = validate($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user_profile WHERE user_name=$input_username AND user_password='$input_password'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_password);
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if the login is successful
    if ($row = mysqli_fetch_assoc($result)) {
        // Start the session and store necessary information
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];

        // Redirect to the home page
        header("Location: ../home/home_page.html");
        exit();
    } else {
        // Redirect to a login error page or display an error message
        header("Location: ../login/login_error.html");
        exit();
    }
}
?>
