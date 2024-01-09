<?php
// Your existing code for login

// Assuming successful login
if (isset($responseData['success'])) {
    // Redirect to the authorization page with user data
    $userData = json_encode(['email' => $_POST['email'], 'other_data' => '...']); // Customize as per your user data
    header("Location: authorize-likha.php?user_data=" . urlencode($userData));
    exit;
} else {
    // Handle login failure
    echo json_encode(['error' => 'Login failed']);
}
?>
