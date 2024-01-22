<?php
    include('home-controllers/home.php');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: text/html; charset=utf-8');

    // Start the session
    session_start();

    // Function to extract token from URL
    // function getTokenFromURL() {
    //     $url = $_SERVER['REQUEST_URI'];
    //     $parts = parse_url($url);
    //     parse_str($parts['query'], $query);
    //     return isset($query['token']) ? $query['token'] : null;
    // }

    // // Function to get user ID based on the token
    // function getUserIdFromToken($token) {
    //     // Connect to your database (replace with your actual database credentials)
    //     $db_host = 'your_database_host';
    //     $db_user = 'your_database_user';
    //     $db_password = 'your_database_password';
    //     $db_name = 'your_database_name';

    //     $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    //     // Check the connection
    //     if (!$conn) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }

    //     // Sanitize the token to prevent SQL injection
    //     $sanitizedToken = mysqli_real_escape_string($conn, $token);

    //     // Fetch user ID from the database based on the token
    //     $query = "SELECT user_id FROM user_register WHERE authorization_token = '$sanitizedToken'";
    //     $result = mysqli_query($conn, $query);

    //     if ($result) {
    //         $row = mysqli_fetch_assoc($result);
    //         $userId = $row['user_id'];
    //         mysqli_close($conn); // Close the database connection
    //         return $userId;
    //     } else {
    //         // Handle the error as needed
    //         echo "Error: " . $query . "<br>" . mysqli_error($conn);
    //         mysqli_close($conn); // Close the database connection
    //         return null;
    //     }
    // }

    // // Get the token from the URL
    // $token = getTokenFromURL();

    // // If the token is present, fetch the user ID and set it in the session
    // if ($token) {
    //     $userId = getUserIdFromToken($token);

    //     // Set the user ID in the session
    //     $_SESSION['user_id'] = $userId;
    // }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
	<link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;800&display=swap"
    />
    <title>Postify Home</title>
    <link rel="stylesheet" href="home-controllers/homepage.css" />
    <link rel="icon" href="/app/assets/images/logo.png" type="image/png" />
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="../assets/images/logo.svg" alt=""></i>POSTIFY
      </div>

      <div class="search_bar">
        <input type="text" placeholder="Search" />
      </div>

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        <i class='bx bx-sun' id="darkLight"></i>
        <img src="../assets/images/profile-default.jpg" alt="" class="profile" />
      </div>
    </nav>
	
	<div id="content-container"></div>

    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <li class="item">
		  <div href="#" class="nav_link submenu_item" data-page="hallu.html">
			<span class="navlink_icon">
			  <i class="bx bx-home-alt"></i>
			</span>
			<span class="navlink">Home</span>
		  </div>
		</li>
          <li class="item">
		  <div href="/notification.html" class="nav_link submenu_item" data-page="notification.html">
			<span class="navlink_icon">
			  <i class="bx bx-bell icon"></i>
			</span>
			<span class="navlink">Notification</span>
		  </div>
		</li>
		<li class="item">
		  <div href="settings.html" class="nav_link submenu_item" data-page="profile.html">
			<span class="navlink_icon">
			  <i class="bx bx-user-circle"></i>
			</span>
			<span class="navlink">Profile</span>
		  </div>
		</li>
        </ul>
        <ul class="menu_items">
          <div class="menu_title menu_setting"></div>
          <!-- start -->
			<!-- start -->
        <li class="item">
          <a href="" class="nav_link submenu_item" id="settingLink">
            <span class="navlink_icon">
              <i class="bx bx-cog"></i>
            </span>
            <span class="navlink">Setting</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </a>
          <ul class="menu_items submenu">
            <a href="./settings/terms_of_service.html" class="nav_link sublink">Terms of Service</a>
            <a href="./settings/privacy_policy.html" class="nav_link sublink">Privacy Policy</a>
            <a href="./settings/community_guidelines.html" class="nav_link sublink">Community Guidelines</a>
            <a href="./settings/account.html" class="nav_link sublink">Account</a>
          </ul>
        </li>
        <!-- end -->
			<!-- end -->
      <li class="item">
        <a href="#" id="logoutLink" class="nav_link">
          <span class="navlink_icon">
            <i class='bx bx-log-out'></i>
          </span>
          <span class="navlink">Logout</span>
        </a>
      </li>      
        </ul>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>

    <!-- JavaScript -->
    <script src="home-controllers/homepage.js"></script>
  </body>
</html>