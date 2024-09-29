<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Debugging: Check if the data is being passed correctly
    if (empty($sender_id) || empty($receiver_id) || empty($message)) {
        echo "Error: Missing data.";
        exit();
    }

    // Prepare the query
    $query = "INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES ('$sender_id', '$receiver_id', '$message', NOW())";

    // Debugging: Display the query for verification
    echo "Executing query: $query";

    if (mysqli_query($conn, $query)) {
        echo "Message sent successfully!";
    } else {
        // Debugging: Output the SQL error
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>
