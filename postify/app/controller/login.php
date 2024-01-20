<?php
session_start();
// include "https://postify.tech/db_conn.php";
include "../../db_conn.php";

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
    $sql = "SELECT * FROM user_register WHERE (user_name = ? OR email = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        $_SESSION['login_error'] = true;
        header("Location: login.html?error=1");
        exit();
    } else {
        $row = mysqli_fetch_assoc($result);

        // Use password_verify to check the hashed password
        if (password_verify($input_password, $row['user_password'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            header("Location: ../home/home_page.html");
            // calling get_token_api function from get-token
            // get_token_api();
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = true;
            header("Location: login.html?error=1");
            exit();
        }
    }
}
?>
