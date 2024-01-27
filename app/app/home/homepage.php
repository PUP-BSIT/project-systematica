<?php
    include('home-controllers/home.php');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: text/html; charset=utf-8');
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
            <a href="./terms_of_service.html" class="nav_link sublink">Terms of Service</a>
            <a href="./privacy_policy.html" class="nav_link sublink">Privacy Policy</a>
            <a href="./community_guidelines.html" class="nav_link sublink">Community Guidelines</a>
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