<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/api-login.css">
    <title>Login as Postify</title>
</head>
<body>
    <div class="login-container">
        <img src="resources/logo.png" alt="Logo Placeholder">
        <h2>Login as Postify</h2>
        <form>
            <input type="text" id="email_field" placeholder="Username" required>
            <div class="password-container">
                <input type="password" placeholder="Password" id="password_field" required>
                <span class="visibility-toggle" onclick="togglePasswordVisibility()">
                    <img src="resources/eye_closed.svg" alt="Closed Eye Icon" id="eyeClosed">
                    <img src="resources/eye_open.svg" alt="Open Eye Icon" id="eyeOpen" style="display: none;">
                </span>
            </div>
            <button type="button" onclick="loginAccount()">Login</button>
        </form>
        <button class="go-back-button" onclick="goBack()">Go Back</button>
    </div>
    <script src="soc-login.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("passwordInput");
            const eyeClosed = document.getElementById("eyeClosed");
            const eyeOpen = document.getElementById("eyeOpen");
        
            console.log("Current passwordInput type:", passwordInput.type);
        
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeClosed.style.display = "none";
                eyeOpen.style.display = "inline";
            } else {
                passwordInput.type = "password";
                eyeClosed.style.display = "inline";
                eyeOpen.style.display = "none";
            }
        
            console.log("New passwordInput type:", passwordInput.type);
        }
    </script>
</body>
</html>
