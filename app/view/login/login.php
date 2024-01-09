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
    $sql = "SELECT * FROM user_profile_test WHERE (user_name = '$input_username' OR email = '$input_username')";

    $result = mysqli_query($conn, $sql);
    
	if (mysqli_num_rows($result) === 0) {
		$_SESSION['login_error'] = true;
		header("Location: login.html?error=1");
		exit();
	} else {
        $row = mysqli_fetch_assoc($result);
        if ($row['user_password'] === $input_password) {
            $_SESSION['email'] = $row['email'];
				$_SESSION['id'] = $row['id'];
				header("Location: ../home/home_page.html");
				exit();
        }
    }
}
    
?>