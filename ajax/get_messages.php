<?php
session_start();
include '../includes/db.php';

if (isset($_GET['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_GET['receiver_id'];

    $query = "SELECT * FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') ORDER BY timestamp ASC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $align = ($row['sender_id'] == $sender_id) ? 'right' : 'left';
        echo "<div style='text-align: $align;'>
                <p>{$row['message']}</p>
                <small>{$row['timestamp']}</small>
              </div>";
    }
}
?>
