<?php
require "../../../db_conn.php";

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT user_id, post_content 
        FROM user_post 
        ORDER BY created_at";
$sql_result = $conn->query($sql);
$post_list;
for ($i = 0; $sql_row = $sql_result->fetch_assoc(); $i++) {
        $post_list[$i] = array(
                'username' => get_username($sql_row['user_id']), 
                'userPost' => $sql_row['post_content']
        );
}
$response['postList'] = $post_list;
$response['success'] = true;
echo json_encode($response);

function get_username($user_id) {
        global $conn;
        $sql = "SELECT username FROM user_register WHERE user_id=$user_id";
        $sql_result = $conn->query($sql);
        $sql_row = $sql_result->fetch_assoc();
        return $sql_row['username'];
}

// require "../../../db_conn.php";

// session_start();

// // Check if the authorization token is present in the URL
// if (isset($_GET['authorization_token'])) {
//     $authorization_token = $_GET['authorization_token'];

//     // Validate and decode the authorization token
//     $user_credentials = validateAndDecodeToken($authorization_token);

//     if ($user_credentials !== false) {
//         // Fetch user ID from the user_register table using the user credentials
//         $user_id = getUserIdFromCredentials($user_credentials);

//         if ($user_id !== false) {
//             // Fetch posts for the authenticated user
//             $post_list = getPostsForUser($user_id);

//             $response['postList'] = $post_list;
//             $response['success'] = true;
//             echo json_encode($response);
//             exit;
//         }
//     }
// }

// // If the token is not present or the token validation fails, check for local session
// if (isset($_SESSION['user_id'])) {
//     $user_id = $_SESSION['user_id'];

//     // Fetch posts for the local session user
//     $post_list = getPostsForUser($user_id);

//     $response['postList'] = $post_list;
//     $response['success'] = true;
//     echo json_encode($response);
//     exit;
// }

// // If no user is authenticated, return an error
// $response['success'] = false;
// $response['message'] = 'User not authenticated';
// echo json_encode($response);
// exit;

// function validateAndDecodeToken($token) {
//     // Implement token validation logic here (e.g., using JWT library)
//     // Return the decoded user credentials if the token is valid, or false otherwise
//     // Example: return JWT::decode($token, $secret_key, array('HS256'));
//     return false;
// }

// function getUserIdFromCredentials($user_credentials) {
//     // Implement logic to fetch user ID from the user_register table using credentials
//     // Example: $username = $user_credentials['username'];
//     //          $password = $user_credentials['password'];
//     //          $sql = "SELECT user_id FROM user_register WHERE username=? AND password=?";
//     //          ... (execute the query and fetch user_id)
//     //          return $user_id;
//     return false;
// }

// function getPostsForUser($user_id) {
//     global $conn;

//     // Use prepared statements to prevent SQL injection
//     $sql = "SELECT user_id, post_content 
//             FROM user_post 
//             WHERE user_id=?
//             ORDER BY created_at";
//     $stmt = $conn->prepare($sql);

//     if (!$stmt) {
//         return array();
//     }

//     $stmt->bind_param('i', $user_id);
//     $stmt->execute();
//     $sql_result = $stmt->get_result();
//     $stmt->close();

//     $post_list = array();

//     while ($sql_row = $sql_result->fetch_assoc()) {
//         $post_list[] = array(
//             'username' => get_username($sql_row['user_id']),
//             'userPost' => $sql_row['post_content']
//         );
//     }

//     return $post_list;
// }

// function get_username($user_id) {
//     global $conn;

//     // Use prepared statements to prevent SQL injection
//     $sql = "SELECT username FROM user_register WHERE user_id=?";
//     $stmt = $conn->prepare($sql);

//     if (!$stmt) {
//         return 'Unknown';
//     }

//     $stmt->bind_param('i', $user_id);
//     $stmt->execute();
//     $stmt->bind_result($username);

//     if ($stmt->fetch()) {
//         $stmt->close();
//         return $username;
//     } else {
//         $stmt->close();
//         return 'Unknown';
//     }
// }
?>
