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
    $sql = "SELECT * FROM user_profile_test WHERE email='$input_username' AND user_password='$input_password'";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_password);

    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if the login is successful
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password using password_verify
        if (password_verify($input_password, $row['user_password'])) {
            // Start the session and store necessary information
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];  // Corrected field name

            // Close the prepared statement
            mysqli_stmt_close($stmt);

            // Redirect to the home page
            header("Location: ../home/home_page.html");
            exit();
        }
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Redirect to a login error page or display an error message
    header("Location: ../login/login_error.html");
    exit();
}
?>
