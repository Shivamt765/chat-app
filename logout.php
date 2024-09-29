<?php
session_start();
include 'includes/db.php';// Database connection

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Set status to offline when the user logs out
    mysqli_query($conn, "UPDATE users SET status='offline' WHERE id='$user_id'");

    session_destroy();
}

header("Location: login.php");
exit();
?>
