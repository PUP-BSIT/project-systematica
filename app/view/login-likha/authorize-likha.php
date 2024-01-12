<?php
session_start(); // Start the session

// Retrieve user data from the session
if (isset($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];

    // Clear the session data if needed
    unset($_SESSION['user_data']);

    // Use $userData as needed for authorization
    // For demonstration purposes, we'll just print the data
    echo json_encode($userData);
} else {
    // Redirect or handle unauthorized access
    header("Location: unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization Likha</title>
</head>
<body>
    <h1>Authorization Page</h1>
    <p>Allow the user to authenticate to this website?</p>
    <form method="post" action="process_authorization.php">
        <input type="hidden" name="user_data" value="<?php echo htmlspecialchars($_POST['user_data']); ?>">
        <button type="submit" name="allow">Allow</button>
        <button type="submit" name="deny">Deny</button>
    </form>
</body>
</html>
