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
header("Location: login-auth.php");
exit();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization for Postify</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <!-- Add any additional styles or scripts you need for your page -->
</head>

<body>
    <div class="authorization-container">
        <h2>Authorization Required</h2>
        <p><strong><application_name></strong> wants to access your data and post on your behalf.</p>

        <!-- Display the list of data that can be accessed -->
        <p>Data accessible by <strong><application_name></strong>:</p>
        <ul>
            <li>User's email: <?php echo $_SESSION['email']; ?></li>
            <!-- Add other data points as needed -->
        </ul>

        <p>Do you authorize <strong><application_name></strong> to access this data?</p>

        <form action="process-authorization.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
            <button type="submit" name="authorize" value="true">Authorize</button>
            <button type="submit" name="authorize" value="false">Deny</button>
        </form>
    </div>
</body>

</html>
