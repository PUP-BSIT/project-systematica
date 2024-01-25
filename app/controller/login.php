<?php
session_start();
header('Content-Type: application/json');
include "../../db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $input_email = validate($_POST['email']);
    $input_password = validate($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user_register WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $input_email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    

    if (mysqli_num_rows($result) === 0) {
        $_SESSION['login_error'] = true;
        header("Location: ../login.html?error=1");
        exit();
    } else {
        $row = mysqli_fetch_assoc($result);

        // Use password_verify to check the hashed password
        if (password_verify($input_password, $row['password_hash'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['user_id'];
        
            $cookie_name = "email";
            $cookie_value =  $_SESSION['email'];
            if (!isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, $cookie_value, time() + 3600, '/', '', true, true);
            }
            
            $response['success'] = true;
            echo json_encode($response);
            
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = true;
            header("Location: ../login.html?error=1");
            exit();
        }
    }
}
?>
