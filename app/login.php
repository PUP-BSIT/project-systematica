<?php
$cookie_name_email = "email";
setcookie($cookie_name_email, "", time() - 3600, "/");

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <title>Postify Login</title>
    <link rel="stylesheet" href="styles/globals.css" />
    <link rel="stylesheet" href="styles/login.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open Sans:wght@400;600;700&display=swap" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Secular One:wght@400&display=swap" />
    <link rel="icon" href="/app/assets/images/logo.png" type="image/png" />
    <script src="controller/login.js"></script>
</head>

<body>
    <div class="registration-page">
        <div class="form">
          <div class="form2">
            <div class="welcome-wrapper">
              <div class="welcome">Welcome</div>
            </div>
            <div class="jnt-stack">
              <div class="jnt-input">
                <div class="input-container username">
                  <input type="text" id="email" name="email" required>
                  <label for="username" id="usernameLabel">
                    <img src="assets/images/email.png" alt="Icon">
                    <span>Email</span>
                  </label>
                </div>
              </div>
              <div class="jnt-input">
                <div class="input-container password">
                  <input type="password" id="password" name="password" required>
                  <label for="password" id="passwordLabel">
                    <img src="assets/images/password.png" alt="Icon">
                    <span>Password</span>
                  </label>
                </div>
              </div>
              <div class="forgot-password">Forgot password?</div>
            </div>
            <div class="buttons-stack-wrapper">
              <div class="buttons-stack">
                <div class="frame-group">
                  <div class="frame-container">
                    <div class="jnt-button-wrapper">
                      <button class="login-button" onclick="login()">Log In</button>
                    </div>
                    <div class="rectangle-parent9">
                      <div class="frame-child6"></div>
                      <div class="placeholder">Or</div>
                      <div class="frame-child6"></div>
                    </div>
                    <div class="button-wrapper">
                      <button class="likha-button">
                          <div class="content14">
                              <img class="likha-logo" alt="" src="assets/images/likha.png" />
                              Likha
                          </div>
                      </button>
  
                      <button class="hypefive-button">
                          <div class="content14">
                              <img class="hypefive-logo" alt="" src="assets/images/hypehive.png" />
                              HypeHive
                          </div>
                      </button>
                      </div>
                  </div>
                  <div class="have-no-account-yet-parent">
                    <div class="placeholder">Have no account yet?</div>
                    <div class="button16">
                       <button class="signup-button" onclick="signup()">Sign Up</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-child">
              <div class="form-item"></div>
              <div class="frame-1"><img class="logo-postify" src="assets/images/logo_postify.png" /></div>
              <div class="frame-2"><img class="astronaut" src="assets/images/astronaut.png" /></div>
          </div>
          <div class="group">
            <div class="welcome-aboard-my">Welcome aboard my friend!</div>
        </div>
      </div>
</body>

</html>