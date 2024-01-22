<?php
require "../../../db_conn.php";

// Assuming you have a user session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id']) && isset($_SESSION['user_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Use prepared statements to prevent SQL injection
    $queryCheckLike = "SELECT * FROM post_like WHERE user_id = ? AND post_id = ?";
    $stmtCheckLike = mysqli_prepare($conn, $queryCheckLike);
    mysqli_stmt_bind_param($stmtCheckLike, 'ii', $user_id, $post_id);
    mysqli_stmt_execute($stmtCheckLike);
    $resultCheckLike = mysqli_stmt_get_result($stmtCheckLike);

    if (mysqli_num_rows($resultCheckLike) == 0) {
        // User hasn't liked the post, so insert a new like
        $queryInsertLike = "INSERT INTO post_like (user_id, post_id, like_time) VALUES (?, ?, NOW())";
        $stmtInsertLike = mysqli_prepare($conn, $queryInsertLike);
        mysqli_stmt_bind_param($stmtInsertLike, 'ii', $user_id, $post_id);

        if (mysqli_stmt_execute($stmtInsertLike)) {
            // Get the updated like count
            $like_count = getLikeCount($conn, $post_id);
            echo json_encode(['success' => true, 'like_count' => $like_count]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error inserting like']);
        }
    } else {
        // User already liked the post, return an error
        echo json_encode(['success' => false, 'error' => 'User already liked the post']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

// Function to get the like count
function getLikeCount($conn, $post_id)
{
    $query = "SELECT COUNT(*) as like_count FROM post_like WHERE post_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['like_count'];
    }

    return 0;
}
?>
