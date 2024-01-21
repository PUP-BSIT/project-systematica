<?php
session_start();
$email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Page</title>
    <script src="authSoc.js"></script>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(180deg, #5c656a 0.01%, #d1d1d1 50.1%, #6981c0);
            font-family: 'Inter', sans-serif; /* Added Inter font */
        }

        .authorization-container {
            text-align: left;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
        }

        .authorization-container p {
            margin-bottom: 1.5em; /* Adjusted paragraph spacing to 1.5 times the font size */
            line-height: 2.0; /* Set line-height to achieve spacing similar to 1.5 in Word */
        }

        .authorization-container p:first-child {
            margin-top: 0; /* Remove space at the top of the first paragraph */
        }

        .button-row {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .allow-button,
        .cancel-button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #fff;
            color: #3949ab;
            border: 1px solid #3949ab;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .allow-button:hover,
        .cancel-button:hover {
            background-color: #3949ab;
            color: #fff;
        }
    </style>

</head>

<body>
    <div class="authorization-container">
        <h1>Authorize this Application</h1>
        <p>
            Authorize and amplify your social presence on Postify! 
            Seamlessly connect with your favorite social media platforms 
            to effortlessly share your content, engage with followers, 
            and extend your digital influence. Experience the power 
            of unified social connectivity with Postify's authorization 
            feature. Empower your online presence like never before.
        </p>
        <div class="button-row">
            <button class="allow-button" type="button" onclick="allowUser()">
                Allow
            </button>
            <button class="cancel-button" type="button" onclick="denyUser()">
                Deny
            </button>
        </div>
    </div>

</body>
</html>