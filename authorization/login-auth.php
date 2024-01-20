<?php
session_start();

$servername = "127.0.0.1:3306";
$username = "u722605549_admin";
$password = "VUbu4Zhkp7=o";
$database = "u722605549_postify_db";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    error_log("Connection established");
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $input_username = validate($_POST['email']);
    $input_password = validate($_POST['password']);
    
    error_log("Username: $input_username, Password: $input_password");

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user_profile_test WHERE (user_name = $input_username OR email = $input_password)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $input_username, $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        error_log("User not found");
        $_SESSION['login_error'] = true;
        header("Location: authorizationPage.php?error=1");
        exit();
    } else {
        $row = $result->fetch_assoc();
        if ($row['user_password'] === $input_password) {
            error_log("Login successful for user: $input_username");
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            header("Location: authorizationPage.php");
            exit();
        } else {
            error_log("Incorrect password for user: $input_username");
        }
    }
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login as Postify</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
</head>

<body>
    <div class="login-container">
        <h2>Login as Likha</h2>
        <form id="likha_login_form" class="form-container" action="login-auth.php" method="post">
            <label for="likha_email"><b>Email</b></label>
            <input type="text" id="likha_email" name="email" />

            <label for="likha_password"><b>Password</b></label>
            <input type="password" id="likha_password" name="password" />
            
            <button type="submit" name="action" value="login" class="btn">Login</button>
        </form>

    </div>
</body>

</html>
