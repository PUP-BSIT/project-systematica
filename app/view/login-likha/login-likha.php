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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
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
    $sql = "SELECT * FROM user_profile_test WHERE (user_name = ? OR email = ?)";

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
        // Hashed password comparison
        if (password_verify($input_password, $row['user_password'])) {
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
<!-- The rest of your HTML code remains unchanged -->
process-authorization.php:
php
Copy code
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['authorize'])) {
        $authorization_result = ($_POST['authorize'] === 'true') ? 'authorized' : 'denied';

        // You can perform additional actions based on the authorization result, such as storing it in a database.

        if ($authorization_result === 'authorized') {
            // Redirect the user to the application's main page after authorization
            header("Location: mainPage.php");
            exit();
        } else {
            // Redirect the user to a page indicating denial of authorization
            header("Location: deniedAuthorizationPage.php");
            exit();
        }
    }
}

// Redirect the user to the login page if the request is not a POST request
header("Location: get-token.php");
exit();
?>